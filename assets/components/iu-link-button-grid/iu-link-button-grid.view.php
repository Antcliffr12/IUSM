<div class="link-button-grid" data-columns="<?= $columns ?>" data-component="Link Button Grid">
	<?php if (!empty($title)) { ?>
		<h1 class="title"><?= $title ?></h1>
	<?php } ?>
	<?php if (!empty($intro)) { ?>
		<div class="intro">
			<?= $intro ?>
		</div>
	<?php } ?>
	<ul class="grid-items">

		<?php foreach ($items as $item) { ?>
			<li class="grid-item"><a href="<?= $item['link'] ?>" target="<?= $item['link_target'] ?>"><?= $item['label'] ?></a></li>
		<?php } ?>
	</ul>
</div>
