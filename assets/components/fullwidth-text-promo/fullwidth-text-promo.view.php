<?php
/**
 * View template for component
 */
$indent = (isset($indented) && $indented == 'true') ? ' indented' : '';
?>
<div class="text-promo <?= $bg_color ?><?= $indent ?>" data-component="Full-width Text Promo">
  <?= $body ?>
</div>
