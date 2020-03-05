<?php
/**
 * View template for component
 */
$heading = '';
 if(!empty($title)){
 	$heading = sprintf(__('<%s>%s</%s>'), $title_element, $title, $title_element);
 }
?>
<div class="<?= $css_classes ?>" data-component="Text with Floated Image">
	<img class="default-img" src="<?= $image_url ?>" alt="">
	<?= $heading ?>
	<article class="body">
		<?= $body ?>
	</article>
	<?php if (count($buttons) > 0) { ?>
		<div class="button-row">
			<?php foreach ($buttons as $button) { ?>
				<a class="button<?= isset($button['iu_logo']) ? " {$button['iu_logo']}" : '' ?>" data-style="default" href="<?= $button['button_link'] ?>"<?= isset($button['button_link_target']) ? ' target="'.$button['button_link_target'].'"' : '' ?>><?= $button['button_text'] ?></a>
			<?php } ?>
		</div>
	<?php } ?>
</div>
