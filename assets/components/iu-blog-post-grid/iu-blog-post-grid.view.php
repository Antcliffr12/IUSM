<?php

	$page_id = get_queried_object_id();
	$hide_breadcrumb = get_post_meta( $page_id, 'hide_breadcrumb', true );

	$landingPageTitle = $title;

	// Handles top margin above the h2 element in the case that the breadcrumb is not present.
	$h1_style = '';


	if(is_multisite()) {

		$siteId = get_current_blog_id();
		if ($siteId != '1') {
			if(is_home() && is_front_page()){
				$landingPageTitle = get_bloginfo( 'name' );
			}else if(is_front_page()){
				$h1_style = ' style="margin-top:55px;"';
			}else if($hide_breadcrumb == 'on') {
				$h1_style = ' style="margin-top:55px;"';
			}
		}else {
			if (is_home() && is_front_page()) {
				$landingPageTitle = get_bloginfo('name');
			} else if (is_front_page()) {
				$h1_style = ' style="margin-top:55px;"';
			} else if ($hide_breadcrumb == 'on') {
				$h1_style = ' style="margin-top:55px;"';
			}
		}
	}else {
		if(is_home() && is_front_page()) {
			$landingPageTitle = get_bloginfo('name');
			$h1_style = ' style="margin-top:55px;"';
		}else if(is_front_page()){
			$h1_style = ' style="margin-top:55px;"';
		}else if($hide_breadcrumb == 'on') {
			$h1_style = ' style="margin-top:55px;"';
		}
	}


?>

<div class="iu-blog-post-grid iu-section-block" data-component="IU Blog Post Grid">
	<div class="container clearfix">
		<h1<?=$h1_style?>><?= $landingPageTitle ?></h1>
	</div>
	<div class="iu-content-grid">
		<div class="grid-container">
		<div class="container clearfix">
			<div class="row grid-items no-margin">

		<?php
			$args = [
				'post_status' => 'publish',
				'post_type' => 'post',
				'orderby' => 'date',
				'order' => 'DESC',
				'posts_per_page' => 9,
			];
			$query = new WP_Query($args);
				$defaultImage = THEME_PATH . '/assets/images/blog-list-placeholder.gif';
				$count = $query->post_count;
			for($i = 0; $i <= $count - 1;$i++){
				$removeMargin = (($i+1) % 3) == 0 ? ' style="margin-right:0;"' : '';
				$post = $query->posts[$i];
				$postId = $post->ID;
				$postThumbnail = has_post_thumbnail($postId) ? get_the_post_thumbnail_url($postId, 'iu-medium') : $defaultImage ;
				?>
					<div class="grid-item"<?= $removeMargin ?>>

						<div class="image">
							<a href="<?= get_permalink($postId); ?>">
								<img src="<?= $postThumbnail ?>" alt="<?= get_the_title($postId); ?>">
							</a>
						</div>

						<h2 class="title"><a href="<?= get_permalink($postId); ?>"><?= get_the_title($postId); ?></a></h2>

					</div>
				<?php
			}


		wp_reset_postdata();


		?>
			<div class="loaded-content"></div>
		<?php

		if($count >= 9){
			?>
				<span class="load-more">Load More</span>
			<?php
		}
		?>
				<span class="ajax-loader"><img src="<?= THEME_PATH . '/assets/components/iu-blog-post-grid/ajax-loader.gif'; ?>" /></span>
				<div class="count" style="display:none;"><?= $count ?></div>
		</div>
		</div>
		</div>
	</div>
</div>
