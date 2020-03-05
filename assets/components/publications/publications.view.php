<?php

require_once TEMPLATEPATH . '/assets/components/publications/publications.class.php';
$defaultImage = THEME_PATH . '/assets/images/IUSM-Home-Blog-Placeholder.gif';

$blogFeed = isset($blog_rss_feed) ? $blog_rss_feed : null;
$blogTitle = isset($blog_feed_title) ? $blog_feed_title : 'Blogssss';
$blogCount = isset($blog_rss_feed_number) ? $blog_rss_feed_number : 6;

$newsFeed = isset($news_rss_feed) ? $news_rss_feed : null;
$newsTitle = isset($news_feed_title) ? $news_feed_title : 'News';
$newsCount = isset($news_rss_feed_number) ? $news_rss_feed_number : 1;
$newsRemoveImage = isset($news_remove_image) ? $news_remove_image : false;
$newsRemoveContent = isset($news_remove_content) ?  $news_remove_content : false;
$has_image = $newsRemoveImage == false ? true : false;
$has_blog = $newsRemoveContent == false ? true : false;
$data = new PublicationsFeed();


$blogData = !is_null($blogFeed) ? $data::GetFeed($blogFeed) : '';
$newsData = !is_null($newsFeed) ? $data::GetFeed($newsFeed) : '';
?>


<div class="publications-column" data-component="Publications Column">
    <div class="row">
        <div class="col-md-12 column_1">
            <h2><?= $newsTitle ?></h2>
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
                            $imageSrc = '';
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


    </div>
</div>
