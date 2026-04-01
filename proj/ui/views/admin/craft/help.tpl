<?php
	/**
	 * @var array $head
	 * @var array $groups
	 */
?>
<div class = "view craft help">
	<div class = "title">
		<pre><code><span class = "m_green"><?= implode("\n", $head); ?></span></code></pre>
	</div>
	<div class = "list">
		<?php foreach ($groups as $group) { ?>
			<div class = "group">
				<h3><?= $group['title']; ?></h3>
				<div>
					<?php foreach ($group['commands'] as $command) { ?>
					<div>
						<h4><?= $command['title'] ?></h4>
						<div class = "code php">
							<code>
								<span class = "command">
									<?php foreach ($command['arguments'] as $argument) { ?>
										<span class = "<?= $argument['color'] ? "m_{$argument['color']}" : ''; ?>"><?= $argument['text']; ?></span>
									<?php } ?>
								</span>
								<?php if (!empty($command['flags'])) { ?>
									<span class = "flags">
									<?php foreach ($command['flags'] as $flag) { ?>
										<span>
											<span class = "m_blue"><?= $flag['name']; ?></span><span>:</span><span class = "m_red"><?= $flag['additionally']; ?></span><span> | <?= $flag['description']; ?></span>
										</span>
									<?php } ?>
								</span>
								<?php } ?>
							</code>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>