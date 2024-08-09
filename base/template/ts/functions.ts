/**
 * Запрашивает контент страницы
 * @param route
 */
function getContent(route: string = ''): void {
	let url = new URL(window.location.href);

	let href = url.origin;
	let pathname = route ? url.pathname.replace(route, `${route}/xhr`) : `/xhr${url.pathname}`;
	let params = url.search;

	Base.Query.sendToAddress(`${href}${pathname}${params}`, undefined, {request: ''});
}