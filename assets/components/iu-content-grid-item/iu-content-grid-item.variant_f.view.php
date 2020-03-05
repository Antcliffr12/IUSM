<div class="grid-item">
	<div class="image">
		<img src="<?= $image_data['url'] ?>" alt="<?= $title ?>">
	</div>
	<h3 class="title">
		<?php if ($title_link) { ?>
			<a href="<?= $title_link ?>" title=""><?= $title ?></a>
		<?php } else { ?>
			<?= $title ?>
		<?php } ?>
	</h3>
	<div class="description">
		<?= $intro ?>
	</div>
</div>
