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
	<div class="body">
		<?= $body ?>
	</div>
	<?php if ($extra1) { ?>
		<h4 class="extra1"><?= $extra1 ?></h4>
	<?php } ?>
	<?php if ($extra2) { ?>
		<span class="extra2"><?= $extra2 ?></span>
	<?php } ?>
</div>
