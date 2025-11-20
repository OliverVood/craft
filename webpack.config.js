const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const SCSS_ENTRIES = {
	site: './proj/sources/scss/site.scss',
	admin: './proj/sources/scss/admin.scss',
	auth: './proj/sources/scss/auth.scss'
};

const TS_ENTRIES = {
	base: '/proj/sources/ts/base.ts',
	admin: '/proj/sources/ts/admin.ts',
	site: '/proj/sources/ts/site.ts',
	db: '/proj/sources/ts/db.ts'
};

module.exports = (env, argv) => {
	const isProduction = argv.mode === 'production';

	// Функция для создания entry points без конфликтов
	const createEntryPoints = () => {
		const entries = {};

		// Добавляем SCSS entries
		Object.keys(SCSS_ENTRIES).forEach(key => {
			entries[`css-${key}`] = SCSS_ENTRIES[key];
		});

		// Добавляем TS entries
		Object.keys(TS_ENTRIES).forEach(key => {
			entries[`js-${key}`] = TS_ENTRIES[key];
		});

		return entries;
	};

	const entryPoints = createEntryPoints();

	return {
		context: __dirname,
		entry: entryPoints,
		output: {
			path: path.resolve(__dirname, 'public'),
			// filename: isProduction ? 'js/[name].min.js' : 'js/[name].js'
			filename: (pathData) => {
				// Убираем префиксы из имен файлов
				const chunkName = pathData.chunk.name;
				const cleanName = chunkName.replace(/^(js-)/, '');
				return isProduction ? `js/${cleanName}.min.js` : `js/${cleanName}.js`;
			},
			// Добавляем настройку для asset modules
			assetModuleFilename: (pathData) => {
				// Определяем тип файла по расширению
				const extension = path.extname(pathData.filename);

				if (['.woff', '.woff2', '.ttf', '.eot', '.otf'].includes(extension.toLowerCase())) {
					return `fonts/[name][ext]`;
				}

				if (['.png', '.jpg', '.jpeg', '.gif', '.svg', '.webp'].includes(extension.toLowerCase())) {
					return `images/[name][ext]`;
				}

				// Для остальных типов файлов
				return `assets/[name][ext]`;
			}
		},
		devtool: isProduction ? false : 'source-map',
		module: {
			rules: [
				{
					test: /\.scss$/,
					use: [
						MiniCssExtractPlugin.loader,
						'css-loader',
						{
							loader: 'sass-loader',
							options: {
								sassOptions: {
									// Настройки для корректной обработки путей
									includePaths: [path.resolve(__dirname, 'proj/sources')]
								}
							}
						}
					]
				},
				{
					test: /\.tsx?$/,
					use: 'ts-loader',
					exclude: /node_modules/
				},
				// Правило для обработки шрифтов
				{
					test: /\.(woff|woff2|ttf|eot|otf)$/i,
					type: 'asset/resource',
					generator: {
						filename: 'fonts/[name]-[hash][ext]'
					}
				},
				// Правило для обработки изображений
				{
					test: /\.(png|jpg|jpeg|gif|svg|webp)$/i,
					type: 'asset/resource',
					generator: {
						filename: 'images/[name]-[hash][ext]'
					}
				}
			]
		},
		resolve: {
			extensions: ['.tsx', '.ts', '.js']
		},
		optimization: {
			minimize: isProduction,
			minimizer: [
				new CssMinimizerPlugin(),
				'...' // сохраняем стандартные минимизаторы Webpack (для JS)
			]
		},
		plugins: [
			// Очистка директорий перед сборкой
			new CleanWebpackPlugin({
				cleanOnceBeforeBuildPatterns: [
					'css/**/*',
					'js/**/*',
					'fonts/**/*',
					'images/**/*',
					'assets/**/*'
				],
				// Опционально: не очищать файлы, которые не будут перезаписаны
				cleanStaleWebpackAssets: false,
				// Опционально: защита от случайного удаления всей папки public
				dangerouslyAllowCleanPatternsOutsideProject: false
			}),
			new RemoveEmptyScriptsPlugin(),
			new MiniCssExtractPlugin({
				// filename: isProduction ? 'css/[name].min.css' : 'css/[name].css'
				filename: (pathData) => {
					// Убираем префиксы из имен CSS файлов
					const chunkName = pathData.chunk.name;
					const cleanName = chunkName.replace(/^(css-|js-)/, '');
					return isProduction ? `css/${cleanName}.min.css` : `css/${cleanName}.css`;
				}
			})
		]
	};
};