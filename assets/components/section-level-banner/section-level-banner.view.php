<?php if($bannerText) {
	$background = (isset($bannerBg) && !empty($bannerBg)) ? 'class="'.$bannerBg.'"' : 'class="bg-iu-crimson"';
	?>
	<div id="section-level-banner" <?= $background ?>>
		<div class="container">
			<h2><?= $bannerText ?></h2>
		</div>
	</div>
<?php } ?>