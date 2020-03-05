<?php
global $iusm_config, $extra_body_classes, $menu_tree, $fp_title, $fp_page_parents;

if (!isset($fp_title) || empty($fp_title))
	$title = get_the_title($id);
else
	$title = $fp_title;
if(is_search())
	$title = __('Search Results', 'codeless');
if(is_404())
	$title = __('404 Not Found', 'codeless');


    $path = isset($post) ? get_page_uri($post->ID) : '';
    $queryObject = get_queried_object();
    $post_type = isset($queryObject->post_type) ? $queryObject->post_type : "";
    $post_title = isset($queryObject->post_title) ? $queryObject->post_title : "";

?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=no" />
    <title>
		<?php
		if (isset($fp_title) && !empty($fp_title)) {
			echo $fp_title; }
        elseif (is_author()){
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $author_id = $author->ID;
            $fname = get_the_author_meta('first_name', $author_id);
            $lname = get_the_author_meta('last_name', $author_id);
            $dname = get_the_author_meta('display_name', $author_id);
            if(!empty($fname) && !empty($lname)){
                echo $fname . ' ' . $lname;
            }else{
                echo $dname;
            }
        }
		elseif (is_archive()) {
			echo  wp_title(''); }
		elseif (is_search()) {

		    // ADJUSTMENT FOR AUTHOR CATEGORY SEARCH
            if ((isset($_GET['v']) && $_GET['v'] == '2')) {
                try{
                    $cat_name = get_the_category_by_ID((int)esc_html($s) );
                    echo 'Search for &quot;' . $cat_name . '&quot;';
                }catch(\Exception $e){
                    echo 'Search for &quot;' . esc_html($s) . '&quot;';
                }
            } else {
                echo 'Search for &quot;' . esc_html($s) . '&quot;';
            }

        }
        elseif (is_404()) {
			echo '404 Not Found'; }
		elseif (is_front_page()) {
			echo bloginfo('name'); }
		else {
			wp_title(''); }
		?>
    </title>
    <link href="https://assets.iu.edu/favicon.ico" rel="shortcut icon" type="image/x-icon">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TGCJLX');</script>
    <!-- End Google Tag Manager -->

	<!-- Analytics Start -->
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-56416819-15', 'auto');
      ga('send', 'pageview');

    </script>
    <!-- Analytics End -->
		<!-- JSON-LD -->
		<script type="application/ld+json">
		{
  "@context": "http://schema.org",
  "@type": "CollegeOrUniversity",
  "url": "https://medicine.iu.edu/",
  "name": "Indiana University School of Medicine",
  "logo": "https://medicine.iu.edu/wp-content/uploads/2018/09/Comm-Ext-IU-Som-201-lockup.jpg",
  "sameAs": [ "https://en.wikipedia.org/wiki/Indiana_University_School_of_Medicine",
  "https://www.facebook.com/IUMedicine/",
  "https://twitter.com/iumedschool",
  "https://www.linkedin.com/school/indiana-university-school-of-medicine/",
  "https://www.instagram.com/iumedschool/"]
  }

		</script>
		<!-- end -->

	<?php
	// Add robots nofollow for custom search page
	if ($post_type == 'page' && strtolower((string)$post_title) == 'search') { ?>
        <meta name="robots" content="noindex, nofollow">
	<?php } ?>
	<?php wp_head(); ?>
    <script src="<?= THEME_PATH ?>/assets/scripts/modernizr.min.js"></script>
    <meta name="google-site-verification" content="gCVci-uey8Evvbxi0_eIFNKHrEPsXhkZ5RsLIjt8uHY" />
    <meta name="format-detection" content="telephone=no" />
	
	<script src="https://www.google.com/recaptcha/api.js?render=6LetVpIUAAAAAJ-doymVly4yKt1T0vXuJsdjV_eT"></script>
	<script>
	  grecaptcha.ready(function() {
		  grecaptcha.execute('6LetVpIUAAAAAJ-doymVly4yKt1T0vXuJsdjV_eT', {action: 'homepage'}).then(function(token) {
			 ...
		  });
	  });
	</script>
</head>
<body <?php body_class(@$extra_body_classes); ?> x-ms-format-detection="none">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TGCJLX"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->



<header>
	<?= render_component('site-bar', ['menu_tree' => $menu_tree]); ?>
</header>

<section id="main-content" role="main">
