<ul class="link-button-list" data-component="Link Button List">
	<?php foreach ($items as $item) { ?>
		<li><a href="<?= $item['link'] ?>" target="<?= $item['link_target'] ?>"><?= $item['label'] ?></a></li>
	<?php } ?>
</ul>
