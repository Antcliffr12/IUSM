<?php
/**
 * Internal component (used by header template)
 */
?>
<ul class="breadcrumbs" aria-label="Breadcrumbs">
  <li><a href="<?php echo esc_url(home_url()) ?>"><?php _e("Home", "iusm"); ?></a></li>
  <?php for($i = count($page_parents) - 1; $i >= 0; $i-- ){ ?>
    <li><a href="<?php echo esc_url(get_permalink($page_parents[$i])) ?>"><?php echo esc_html(get_the_title($page_parents[$i])) ?></a></li>
  <?php }  ?>
  <li class="active" aria-label="current page">
    <span><?php echo esc_html($title) ?></span>
  </li>
</ul>
