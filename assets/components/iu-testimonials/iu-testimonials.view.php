<div class="iu-testimonals <?= $bg_color ?>" data-columns="<?= $columns ?>" >
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
