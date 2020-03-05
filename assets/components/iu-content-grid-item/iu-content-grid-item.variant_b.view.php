<div class="grid-item">
	<div class="image">
		<img src="<?= $image_data['url'] ?>" alt="<?= $title ?>">
	</div>
	<h2 class="title">
		<?php 
		if ($title_link == '/') :
			echo $title;
		else:
			?>
			<a href="<?= $title_link ?>"><?= $title ?></a>
		<?php 
		endif;
		?>
		</h2>
	<div class="description">
		<?= $intro ?>
	</div>
</div>
