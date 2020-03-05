<?php
global $post;

if (isset($post->ID)) {

	$content = '';
	$candidates = get_post_ancestors($post->ID);

	array_unshift($candidates, $post->ID);

	// Get closest instance of footer content as stored in page meta field.
	foreach ($candidates as $pid) {
		$content .= get_post_meta($pid, 'section_footer_content', true);
		if ($content != '') { ?>
			<div id="section-footer" aria-label="Section Footer" class="bg-iu-cream">
				<div class="container">
					<div class="row">
						<?= $content ?>
					</div>
				</div>
			</div>
			<?php break;
		}
	}
}
