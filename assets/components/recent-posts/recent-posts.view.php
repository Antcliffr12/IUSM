<?php
require_once TEMPLATEPATH . '/assets/components/recent-posts/lib/loops.php';
$is_multiSite = is_multisite();
$categoryLinkSettings = isset($category_link_settings) ? json_decode(urldecode($category_link_settings)) : '';
$recentPostSiteSelection = isset($recent_posts_site_selection) ? json_decode(urldecode($recent_posts_site_selection)) : '';
$defaultImage = THEME_PATH . '/assets/images/IUSM-Home-Blog-Placeholder.gif';
$feed = RSS_FEED($rss_feed);
$feedCount = empty($rss_feed_number) ? 1 : $rss_feed_number;


?>

<div class="recent-posts clearfix" data-component="Recent Posts">
    <div class="container">
		<?php if (!empty($title)): ?>
            <h1><?= $title ?></h1>
			<?php
		endif;

		if (!empty($description)): ?>
            <p><?= $description ?></p>
			<?php
		endif;

		if (isset($button_url) && !empty($button_url)) {
			$title = isset($button_title) ? 'title="' . $button_title . '" ' : '';
			$target = isset($button_target) ? 'target="' . $button_target . '" ' : '';
			$rel = isset($button_rel) ? 'rel="' . $button_rel . '" ' : '';
			?>
            <a class="button" aria-label="<?= $button_title ?>" href="<?= $button_url ?>" <?= $title . $target . $rel ?>><?= $button_title ?></a>
			<?php
		}
		?>

        <div class="recent-posts-container row">
            <div class="col-sm-6">
                <div class="posts">
                    <h1>Recent Posts</h1>
                    <div class="recent-posts-slider post-slide-container">
                        <div class="recent-post-content">
							<?php
							if (!empty($feed)) {
								?>
                                <div class="image">
									<?php
									for ($i = 0; $i <= $feedCount - 1; $i++) {
										?>
                                        <div class="item">
                                            <a href="<?= $feed[$i]['link'] ?>" title="<?= $feed[$i]['title'] ?>"
                                               data-post-id="<?= $i ?>" target="_blank" alt="<?= $feed[$i]['title'] ?>"><img src="<?= $defaultImage ?>" alt="<?= $feed[$i]['title'] ?>"/></a>
                                        </div>
										<?php
									}
									?>
                                </div>
                                <div class="post-content">
									<?php
									for ($i = 0; $i <= $feedCount - 1; $i++) {
										?>
                                        <div class="item">
                                            <div class="title-content">
                                                <div class="location"></div>
                                                <div class="title">
                                                    <a href="<?= $feed[$i]['link'] ?>" title="<?= $feed[$i]['title'] ?>" target="_blank">
                                                        <h2><?= $feed[$i]['title'] ?></h2></a>
                                                </div>
                                            </div>
                                            <article class="phone-hide tablet-hide">
                                                <?= LimitText(strip_shortcodes(strip_tags($feed[$i]['desc'])), 40); ?>
                                            </article>
                                        </div>
										<?php
									}
									?>
                                </div>
								<?php
							} else {
								?>
                                <div class="image">
									<?php
									$number = !empty($post_number) ? $post_number : -1;


									$imageData = RECENT_POST_IMAGE_DATA($is_multiSite, $recentPostSiteSelection);

									$imageLimit = $number == -1 ? count($imageData) - 1 : count($imageData) < $number ? count($imageData) - 1 : $number - 1;
									for ($imgInt = 0; $imgInt <= $imageLimit; $imgInt++) {
										$data = $imageData[$imgInt];

										$id = isset($data['post_id']) ? $data['post_id'] : '';
										$title = isset($data['title']) ? $data['title'] : '';
										$link = isset($data['permalink']) ? $data['permalink'] : '';
										$image_src = isset($data['imageSrc']) ? !empty($data['imageSrc']) ? $data['imageSrc'] : $defaultImage : $defaultImage;
										$image_alt = isset($data['imageAlt']) ? $data['imageAlt'] : $title;

										?>
                                        <div class="item">
                                            <a href="<?= $link ?>" title="<?= $title ?>" data-post-id="<?= $id ?>"><img
                                                    src="<?= $image_src ?>" alt="<?= $image_alt ?>"/></a>
                                        </div>
										<?php

									}

									?>
                                </div>
                                <div class="post-content">
									<?php

									$contentData = RECENT_POST_CONTENT_DATA($is_multiSite, $recentPostSiteSelection);
									$contentLimit = $number == -1 ? count($contentData) - 1 : count($contentData) < $number ? count($contentData) - 1 : $number - 1;


									for ($cntInt = 0; $cntInt <= $contentLimit; $cntInt++) {
										$data = $contentData[$cntInt];


										$id = isset($data['post_id']) ? $data['post_id'] : '';
										$termLink = isset($data['termLink']) ? $data['termLink'] : '';
										$categoryName = isset($data['categoryName']) ? $data['categoryName'] : '';
										$link = isset($data['permalink']) ? $data['permalink'] : '';
										$title = isset($data['title']) ? $data['title'] : '';
										$content = isset($data['content']) ? $data['content'] : '';

										?>
                                        <div class="item">
                                            <div class="location">
                                                <?php if (!empty($categoryName)): ?>
                                                    From the <a
                                                            href="<?= $termLink ?>"><span><?= $categoryName ?></span></a> blog:
                                                <?php endif; ?>
                                            </div>
                                            <div class="title">
                                                <a href="<?= $link ?>" title="<?= $title ?>"><h2><?= $title ?></h2></a>
                                            </div>
                                            <article class="phone-hide tablet-hide">
                                                <?= LimitText(strip_shortcodes(strip_tags($content)), 40); ?>
                                            </article>
                                        </div>
										<?php
									}


									?>
                                </div>
								<?php
							}
							?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="categories">


					<?php
					$categoryData = CATEGORY_DATA($categoryLinkSettings);
					$defaultCategoryImage = THEME_PATH . '/assets/images/IUSM-Home-Blog-Category-Placeholder.gif';
					$count = count($categoryData);
					?>
                    <ul data-count="<?= $count ?>">
						<?php
						$loopOne = ceil($count / 2);
						for ($i = 0; $i <= $loopOne - 1; $i++) {
							$data = $categoryData[$i];
							$link = isset($data['link']) ? $data['link'] : '';
							$imageSrc = isset($data['imageSrc']) ? !empty($data['imageSrc']) ? $data['imageSrc'] : $defaultCategoryImage : $defaultCategoryImage;
							$title = isset($data['title']) ? $data['title'] : '';

							?>
                            <li>
                                <div class="category-item">
                                    <a href="<?= $link ?>" title="<?= $title ?>">
										<?php if (!empty($imageSrc)): ?>
                                            <img class="tablet-hide phone-hide" src="<?= $imageSrc ?>"
                                                 alt="<?= $title ?>"/>
										<?php endif; ?>
                                        <span><?= $title ?></span>
                                    </a>
                                </div>
                            </li>
							<?php
						}
						?>
                    </ul>
                    <ul>
						<?php
						for ($i = $loopOne; $i <= $count - 1; $i++) {
							$data = $categoryData[$i];
							$link = isset($data['link']) ? $data['link'] : '';
							$imageSrc = isset($data['imageSrc']) ? !empty($data['imageSrc']) ? $data['imageSrc'] : $defaultCategoryImage : $defaultCategoryImage;
							$title = isset($data['title']) ? $data['title'] : '';
							?>
                            <li>
                                <div class="category-item">
                                    <a href="<?= $link ?>" title="<?= $title ?>">
										<?php if (!empty($imageSrc)): ?>
                                            <img class="tablet-hide phone-hide" src="<?= $imageSrc ?>"
                                                 alt="<?= $title ?>"/>
										<?php endif; ?>
                                        <span><?= $title ?></span>
                                    </a>
                                </div>
                            </li>
							<?php
						}
						?>
                    </ul>

					<?php


					?>


                </div>
            </div>

        </div>
    </div>
</div>
