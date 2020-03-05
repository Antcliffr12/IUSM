<?php
/**
* View template for component
*/
?>
<div class="half-n-half l-fullwidth row-fluid clearfix no-padding <?= $placement ?>" data-component="Half-n-Half">
	<div class="image desktop-show col-lg-6 no-padding" style="background-image: url('<?= $image_url ?>');" aria-label="Image. <?= $title ?>">
		<?= $video ?>
	</div>
	<div class="body col-xs-12 col-lg-6">
		<article class="content">
			<h2><?= $title ?></h2>
			<div class="body-text">
				<?= $body ?>
			</div>
			<?php if (count($buttons) > 0) { ?>
				<div class="button-row">
					<?php foreach ($buttons as $button) { ?>
						<a class="button" data-style="default" title="<?= $button['button_text'] ?>" href="<?= $button['button_link'] ?>"><?= $button['button_text'] ?></a>
					<?php } ?>
				</div>
			<?php } ?>
		</article>
	</div>
</div>
