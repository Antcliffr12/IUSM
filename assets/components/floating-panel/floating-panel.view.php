<?php

// Based on design, if no button then h* element is bold.
$bold = (!isset($panel_button_link) && !isset($panel_button_text)) ? ' style="font-weight:bold;"' : '';
$indent = isset($indented) ? $indented == 'true' ? ' indented' : '' : '';
$isAlert = isset($panel_alert) ? $panel_alert == 'true' ? ' is-alert' : '' : '';

?>
<div class="floating-panel clearfix<?= $isAlert ?><?= $indent ?>" data-component="Content Block with Floated Side Panel (Deprecated)">
	<article>
		<h2><?= $title ?></h2>
		<div class="body-content">

			<div class="panel-box">
				<div class="alert-image-container"><span class="alert-image"></span></div>
				<div class="panel-content">
					<h3<?= $bold ?>><?= $panel_title ?></h3>
					<p><?= $panel_body ?></p>
					<?php if(isset($panel_button_link) && isset($panel_button_text)) : ?>
						<a href="<?= $panel_button_link ?>" class="button" title="<?= $panel_button_text ?>"><?= $panel_button_text ?></a>
					<?php endif; ?>
				</div>
			</div>

			<p><?= $body ?></p>
		</div>
	</article>
</div>
