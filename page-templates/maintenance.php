<?php
/* Template Name: Maintenance Page */
?>
<!DOCTYPE html>
<head>
    <meta charset="<?php bloginfo( 'charset' ) ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=no">
    <title>
		<?php
			wp_title('');
		?>
    </title>
    <link href="https://fonts.iu.edu/style.css?family=BentonSans:regular,bold|BentonSansCond:regular,bold" media="screen" rel="stylesheet" type="text/css">

	<?php wp_head(); ?>
<style>
html{margin-top:0px !important;}
</style>
</head>
<body>
  <?php
  global $extra_body_classes;
  $extra_body_classes = 'page-layout-full-width error404';
  $maintenanceImage = THEME_PATH . '/assets/images/maintenance.jpg';
  ?>

      <section class="iu-section-block error404"  data-component="IU Section Block">
          <div class="l-fullwidth clearfix">
              <div class="item">
                <div style="background-image: url(<?php echo $maintenanceImage ?>); background-size: cover; background-position: center; height:100vh;" />

                  <!--<img src="<?= $maintenanceImage ?>" alt="Maintenance: Page Under Construction." class="img-responsive"> -->
                      <div class="overlay-box" style="position:absolute ; bottom:0px;">
                          <h1>Page is Under Contruction</h1>
                          <p>Find information about the IU School of Medicine <a style="color:#990000;" href="https://medicine.iu.edu">here</a>.</p>
                      </div>
                  </div>
              </div>
          </div>
      </section>


</body>
</html>
