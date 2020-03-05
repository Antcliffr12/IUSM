<?php
/**
 * Displays a grid layout of faculty members
 */
?>
<div class="<?= $classes ?>" data-columns="<?= $columns?>" data-component="Faculty Member Grid">
	<?php if (!empty($title)) {?>
		<h1 class="grid-title"><?= $title ?></h1>
	<?php } ?>
	<?php if (!empty($intro)) {?>
		<div class="grid-intro">
			<?= $intro ?>
		</div>
	<?php } ?>
	<div class="row grid-items">
		<?php foreach ($faculty as $member) { ?>
			<div class="grid-item">
				<div class="image">
					<img src="<?=getFacultyImage($member['pid'])?>" alt="<?= $member['fullname'] ?>">
				</div>
				<div class="info-wrapper">
					<div class="info">
						<h2 class="title">
							<a href="<?= $member['url'] ?>" title="<?= $member['fullname'] ?>" aria-label="<?= $member['fullname'] ?>"><?= $member['fullname'] ?></a>
						</h2>
						<div class="subtitle"><?= $member['position'] ?></div>
						<?php if (isset($member['description'])) {?><div class="description"><?= $member['description'] ?></div><?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
