<section class="section-explore-links" data-component="Section Explore Links">
  <div class="container">
    <h1><?= $title ?></h1>
    <div class="row">
      <div class="col-xs-12 col-sm-4">
        <?= $body ?>
      </div>
      <div class="col-xs-12 col-sm-8">
        <ul class="row">
            <?php

              $subnav_root_path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),'/');
              if (!is_null(DEFAULT_SIDEBAR_MENU_ID) && !empty(DEFAULT_SIDEBAR_MENU_ID)) {
                                wp_nav_menu(array(
                                    'menu' => DEFAULT_SIDEBAR_MENU_ID,
                                    'container' => false,
                                    'items_wrap' => '%3$s',
                                    'walker' => new WalkerNavSidebar(),
                                    'sub_menu' => true,
                                    'subnav_root_path' => $subnav_root_path,
                                    'children_only' => true,
                                    'li_item_classes' => 'col-xs-12 col-sm-6 col-xl-4',
                                ));
              }
            ?>

        </ul>
      </div>
    </div>
  </div>
</section>
