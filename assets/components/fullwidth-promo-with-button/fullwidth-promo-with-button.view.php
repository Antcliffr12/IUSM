<?php
$indent = (isset($indented) && $indented == 'true') ? ' indented' : '';
$logo = (isset($link_logo) && $link_logo == 'true') ? ' add-logo' : '';

?>
<div class="full-width-promo-with-button <?= $bg_color ?><?= $indent ?>" data-component="Full-width Promo with Button">

	<h2><?= $title ?></h2>
	<p><?= $body ?></p>
	<a href="<?= $button_link ?>" class="button<?= $logo ?>" aria-role="button" title="<?= $button_text ?>" ><span class="text"><?= $button_text ?></span></a>

	<?php if(isset($info_button_link) && isset($info_button_text)) : ?>
		<a href="<?= $info_button_link ?>" class="button" aria-role="button" title="<?= $info_button_text ?>"><span class="text"><?= $info_button_text ?></span></a>
	<?php endif; ?>

</div>
