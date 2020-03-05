<?php

$heading = '';
if(!empty($title)){
	$heading = sprintf(__('<%s>%s</%s>'), $title_element, $title, $title_element);
}

?>


<div class="fullwidth-content-image" data-component="Split Content Image">
	<div class="container">
		<?= $heading ?>
	</div>
	<?php
		if(isset($image)):

			$image_src = wp_get_attachment_image_src($image, 'iu-massive');
			$image_src = isset($image_src[0]) ? $image_src[0] : '';

			$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
			$image_alt = !empty($image_alt) ? $image_alt : get_the_title(get_the_ID());

			?>
				<img src="<?= $image_src ?>" alt="<?= $image_alt ?>" />
				<p><?= $content ?></p>

			<?php
		endif;
	?>
</div>
