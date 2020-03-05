<div class="<?= $classes ?>" data-component="Feature Block">
	<?php if (isset($title) && !empty($title)): ?>
		<h1><?= $title ?></h1>
	<?php endif; ?>
	<div class="content clearfix">
		<img src="<?= $image_url ?>" alt=""/>
		<article>
			<h2><?= $subtitle ?></h2>
			<p><?=$body?></p>
		</article>
	</div>
</div>
