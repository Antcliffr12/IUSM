<?php
/**
 * Displays a grid layout of items which have identical interior layouts
 */
?>
<div class="<?= $classes ?>" data-columns="<?= $columns?>" data-component="Grid Type <?= $variant ?>">
	<?php if (!empty($title)) {?>
		<h1 class="grid-title"><?= $title ?></h1>
	<?php } ?>
	<?php if (!empty($intro)) {?>
		<div class="grid-intro">
			<?= $intro ?>
		</div>
	<?php } ?>
	<div class="row grid-items">
		<?= $content ?>
	</div>
</div>
