<?php

require_once TEMPLATEPATH . '/assets/components/blog-news-split-column/blog-news-split-column.class.php';
$defaultImage = THEME_PATH . '/assets/images/IUSM-Home-Blog-Placeholder.gif';

$blogFeed = isset($blog_rss_feed) ? $blog_rss_feed : null;
$blogTitle = isset($blog_feed_title) ? $blog_feed_title : ' ';
$blogCount = isset($blog_rss_feed_number) ? $blog_rss_feed_number : 6;
$has_title = $blogTitle == '' ? false : true;

$newsFeed = isset($news_rss_feed) ? $news_rss_feed : null;
$newsTitle = isset($news_feed_title) ? $news_feed_title : 'News';
$has_newsTitle = $newsTitle == '' ? false : true;
$newsCount = isset($news_rss_feed_number) ? $news_rss_feed_number : 1;
$newsRemoveImage = isset($news_remove_image) ? $news_remove_image : false;
$has_image = $newsRemoveImage == false ? true : false;

$data = new BlogNewsFeed();


$blogData = !is_null($blogFeed) ? $data::GetFeed($blogFeed) : '';
$newsData = !is_null($newsFeed) ? $data::GetFeed($newsFeed) : '';
?>


<div class="blog-news-split-column" data-component="Blog News Split Column">
    <div class="row">
        <div class="col-md-6 column_1">
          <?php if ($has_newsTitle){ ?>
              <h1><?= $newsTitle ?></h1>
          <?php } else{
            echo '<h1 class="blogs-no-title">' . $newsTitle . '</h1>';
            } ?>
            <ul>
                <?php
                if(!empty($newsData)) {
                    $i = 0;
                    foreach ($newsData as $newsItem):
                        $i += 1;
                        if($i > $newsCount) { break; }
                        $title = isset($newsItem['title']) ? $newsItem['title'] : '';
                        $link = $newsItem['link'];

                        if($has_image){
                            echo '<li class="has_image">';
                        }else{
                            echo '<li>';
                        }
                        ?>
                            <?php
                            $imageSrc = isset($newsItem['image']) ? $newsItem['image'] : '';
                            $imageSrc = !empty($imageSrc) ? $imageSrc : $defaultImage;
                            ?>
                            <?php if($has_image){ ?>
                                <a style="padding:0;" href="<?= $link ?>" aria-label="<?=$title?>"><img src="<?= $imageSrc ?>" alt="" /></a>
                            <?php } ?>
                            <a href="<?= $link ?>"><?= $title ?></a>
                            <div style="clear:both;"></div>
                        </li>
                        <?php
                    endforeach;
                }else{
                    ?>
                    <li>Feed Data Unavailable.</li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="col-md-6 column_2">
          <?php if ($has_title){ ?>
            <h1><?= $blogTitle ?></h1>
          <?php } else{
            echo '<h1 class="blogs-no-title">' . $blogTitle . '</h1>';
            } ?>
            <ul>
                <?php
                if(!empty($blogData)) {
                    unset($blogData[0]);

                    $i = 0;
                    foreach ($blogData as $blogItem):
                        $i += 1;
                        if($i > $blogCount) { break; }
                        $title = isset($blogItem['title']) ? $blogItem['title'] : '';
                        $link = $blogItem['link'];
                        ?>
                        <li><a href="<?= $link ?>"><?= $title ?></a></li>
                        <?php
                    endforeach;
                }else{
                    ?>
                    <li>Feed Data Unavailable.</li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>
