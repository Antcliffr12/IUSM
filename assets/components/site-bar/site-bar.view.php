<div id="site-bar" class="add-box-shadow">
    <div class="container">

        <div id="top-nav" class="tablet-hide phone-hide clearfix">
	        <a class="btn-toggle-search-bar" aria-label="search bar toggle button" href="/search">Search</a>
	        <nav role="navigation" aria-label="top bar menu">
                <ul class="menu">

                </ul>
            </nav>
        </div>

        <div id="search-bar">
            <?php do_shortcode('[site-search placeholder="Search"]'); ?>
        </div>

        <div class="header-menu-content clearfix">

            <a id="logo" title="IU School of Medicine" href="/">
                <img class="normal" src="<?= THEME_PATH ?>/assets/images/iusm-logo.svg" alt="IU School of Medicine Logo">
                <img class="not-normal" src="<?= THEME_PATH ?>/assets/images/iusm-logo-shrink.svg" alt="IU School of Medicine Logo">
            </a>

            <a class="btn-toggle-mobile-menu phone-show tablet-show desktop-hide">&nbsp;</a>

            <div class="main-menu" data-copytotop="about,careers,give" data-exclude="about,careers,give">

      
            <div class="mobile-search tablet-show phone-show desktop-hide">
            <form role="search" aria-label="mobile search" method="get" action="<?= get_home_url(); ?>">
                        <label for="mobile-q" class="hidden">Enter Your Search Text</label>
                        <input type="text" placeholder="Search" value="<?= get_search_query(); ?>" name="q" id="mobile-q">
                        <span class="search-submit"><input type="submit" id="mobile-searchsubmit" value="Search"></span>
                    </form>
                </div>


                <nav aria-label="main menu">
                    <?php if (!isset($_GET['hidenav']) && has_nav_menu('main')) {

                        if(!isset($_GET['hide_walker'])) {
                            wp_nav_menu(array(
                                'theme_location' => 'main',
                                'walker' => new header_mobile_walker(),
                                'container_class' => 'main-menu-container',
                            ));
                        }else{
                            wp_nav_menu( array(
                                'theme_location' => 'main',
                                'depth' => 2,
                                'container_class' => 'main-menu-container',
                            ) );
                        }

                    } ?>
                    <a class="btn-toggle-search-bar" aria-label="search bar toggle button" href="/search">Search</a>
                </nav>
            </div>

        </div>
        <!-- site-bar megamenu will be output here via ajax request -->
    </div>
</div>
