<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>

<?php

$twitter_username = (isset($twitter_username) && !empty($twitter_username)) ? $twitter_username :'IUNewsroom';
// echo $twitter_username;
//Keys and Tokens
$consumer_key = 'tKt9fPVZu5IHeyq9eoyws8X3z';
$consumer_secret = '7XMMikzWbqAhallaP6aJIESiMZymQeM425Ybggrtwnj9WKv9Vr';
$access_token = '506549544-3rHokWyvxxxQOnJomeH0jdSonqfzgERd3CDarYAJ';
$access_token_secret = 'aabFGRAvGwWJL6APHCamVCt8kA5S2KbflPd5MsVo7mn6M';

//library
require "twitteroauth-master/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;



$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials");


$content = $connection->get("statuses/user_timeline", ["screen_name" => $twitter_username, "count" => 1, "include_rts" => false, "exclude_replies" => true]);
// echo '<pre>';
// echo print_r($content);
// echo '</pre>';
foreach($content as $results){
  $tweet = $results->text;
  $tweet_id = $results->id;
    //URL Regular Expression
   $tweet = preg_replace("/([\w]+\:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/", "<a target=\"_blank\" href=\"$1\">$1</a>", $tweet);

   //Hashtag Regular Expression
   $tweet = preg_replace("/#([A-Za-z0-9\/\.]*)/", "<a target=\"_new\" href=\"http://twitter.com/search?q=$1\">#$1</a>", $tweet);

   //Handle Name Twitter Regular Expression
   $tweet = preg_replace("/@([A-Za-z0-9_\-\/\.]*)/", "<a target=\"_blank\" href=\"http://www.twitter.com/$1\">@$1</a>", $tweet);


   ?>
   <div class="twitter">
     <div class="col-md-8 col-sm-12">
       <div class="latest-social-post">
         <p class="retweet">
           <a class="intent" href="https://twitter.com/intent/retweet?tweet_id=<?= $tweet_id ?>">Retweet</a>
           @<?= $twitter_username ?>
         </p>
         <p class="text">
           <?= $tweet ?>
         </p>
       </div>
     </div>
     <div class="col-md-4 col-sm-12">
       <div class="latest-social">
         <h2>Get Social</h2>
         <p>
           See what's happening at Indiana University School of Medicine
         </p>
         <a class="button invert external" target="_blank" href="https://twitter.com/<?= $twitter_username ?>">Follow IU School of Medicine on Twitter </a>
       </div>
     </div>
   </div>
   <?php

}
