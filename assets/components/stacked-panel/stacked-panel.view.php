<?php


?>
<div class="stacked-panel<?= $isAlert ?><?= $intend ?>" data-component="Stacked Panel (Deprecated)">

	<?php if ($title || $body) : ?>
	<article>
		<?php if ($title) : ?><h1><?= $title ?></h1><?php endif; ?>
		<?php if ($body) : ?><p><?= $body ?></p><?php endif; ?>
	</article>
	<?php endif; ?>

	<div class="info-box">
		<div class="alert-image-container"><span class="alert-image"></span></div>
		<div class="info-content">
			<h2><?= $info_block_title ?></h2>
			<p><?= $info_block_body ?></p>

			<?php if(isset($info_button_link) && isset($info_button_text)) : ?>
				<a href="<?= $info_button_link ?>" class="button" title="<?= $info_button_text ?>"><?= $info_button_text ?></a>
			<?php endif; ?>
		</div>
		<div class="clearfix"></div>
	</div>

</div>
