<?php
$has_alert = isset($no_alert) ? $no_alert : false;
$text_less = substr($body,0, -5). "...";

?>
<?php if($has_alert == 'true'){ ?>
<div class="notifcation-bar">

  <div class="flex">
    <div class="alert_text">
    <h3><?= $title ?></h3>
      <h4 class="text">
        <span><?= $text_less ?></span>
      </h4>
    </div>

      <p>
        <a href="<?= $url ?>" />
          Read More
        </a>

  </div>

</div>
<?php } ?>
