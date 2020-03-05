<aside class="<?= $css_classes ?>" data-component="Callout Box">
	<?php if ($title != '') { ?><h2><?= $title ?></h2><?php } ?>
	<div class="body">
		<?= $body ?>
	</div>
	<?php if (count($buttons) > 0) { ?>
		<div class="button-row">
			<?php foreach ($buttons as $button) { ?>
				<a class="button<?= isset($button['iu_logo']) ? " {$button['iu_logo']}" : '' ?>" role="button" data-style="default" href="<?= $button['button_link'] ?>"<?= isset($button['button_link_target']) ? ' target="'.$button['button_link_target'].'"' : '' ?>><?= $button['button_text'] ?></a>
			<?php } ?>
		</div>
	<?php } ?>
</aside>
