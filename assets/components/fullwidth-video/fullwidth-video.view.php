<?php

global $wp_embed;
$heading = '';
if(!empty($title)){
	$heading = sprintf(__('<%s>%s</%s>'), $title_element, $title, $title_element);
}
$ratio = isset($el_aspect) ? $el_aspect : '';
$class = isset($el_class) ? ' '. $el_class : '';
$alignment  = (isset($align) && !empty($align)) ? ' ' . $align : ' center';
$video_image  = isset($video_image) ? $video_image : '';
$width = isset($el_width) ? ' style="width:'. $el_width .'%;"' : '';
$expand = isset($expand) ? $expand : '';
?>

<div class="fullwidth-video" data-component="Full-width Video">

	<?php if(!empty($heading)){ ?>
        <div class="container">
			<?= $heading ?>
        </div>
	<?php } ?>
		<?php if($video_image == ''){?>
    <div class="video-container <?= $bg_color ?>">
		<?php
				} else {
					$image_src = wp_get_attachment_image_src($video_image,'iu-massive');
					$image_src = isset($image_src[0]) ? $image_src[0] : '';
					 ?>
						<div style="background-image: url('<?= $image_src ?>');">
		<?php
				}
		?>
		<?php if($expand == ''){ ?>
        <div class="container">
			<?php } ?>

            <div class="embed-container <?= $alignment ?>" <?=$width?>>
                <div class="embed clearfix" data-ratio="<?= $ratio ?>">
					<?php
					if(isset($link)):
						echo $wp_embed->run_shortcode('[embed class="dumb"]'. $link .'[/embed]');
					endif;
					?>
                </div>
            </div>
            <div style="clear:both;"></div>
	        <?php if($expand == ''){ ?>
        </div>
	<?php } ?>
    </div>
</div>
