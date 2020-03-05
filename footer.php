
</section><!-- end #main-content -->

<?php global $iusm_config; ?>


<?php
    if(!is_search()){
        echo render_component('iu-section-footer');
    }
?>

<footer role="contentinfo">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-3 col-pos-1">
                    <article>
                        <h2><?php echo $iusm_config['about-section-title'] ?></h2>
                        <p><?php echo $iusm_config['about-section-content'] ?></p>
                    </article>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-3 col-pos-2">
                    <div class="footer-menu clearfix">
                        <h2><?php echo $iusm_config['footer-menu-title'] ?></h2>
                        <nav role="navigation" aria-label="footer navigation">
							<?php
							if (has_nav_menu('footer')) {
								wp_nav_menu( array(
									'theme_location' => 'footer',
									'walker' => new split_walker,
									'items_wrap' => '<ul class="menu">%3$s</ul>',
								) );
							}
							?>
                        </nav>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-3 col-pos-3">
                    <div class="contact-info">
                        <h2><?php echo $iusm_config['contact-info-title'] ?></h2>
                        <div class="locationInformation">
							<?php
							$addressOne = (isset($iusm_config['address-one']) && !empty($iusm_config['address-one'])) ? $iusm_config['address-one'] . '<br />' : '';
							$addressTwo = (isset($iusm_config['address-two']) && !empty($iusm_config['address-two'])) ? $iusm_config['address-two'] . '<br />' : '';
							$addressThree = (isset($iusm_config['address-three']) && !empty($iusm_config['address-three'])) ? $iusm_config['address-three'] . '<br />' : '';
							$addressFour = (isset($iusm_config['address-four']) && !empty($iusm_config['address-four'])) ? $iusm_config['address-four'] . '<br />' : '';
							$city = (isset($iusm_config['city']) && !empty($iusm_config['city'])) ? $iusm_config['city'] . ',' : '';
							$state = (isset($iusm_config['state']) && !empty($iusm_config['state'])) ? $iusm_config['state'] : '';
							$zip = (isset($iusm_config['zip']) && !empty($iusm_config['zip'])) ? $iusm_config['zip'] : '';
							?>
                            <p>
								<?= $addressOne ?>
								<?= $addressTwo ?>
								<?= $addressThree ?>
								<?= $addressFour ?>
								<?= $city ?> <?= $state ?> <?= $zip ?>
                            </p>
                            <p>
                                <a href="tel:+<?php echo StripPhoneNumber($iusm_config['phone']); ?>" title="Contact Phone Number" aria-label="Contact Phone Number"><?php echo $iusm_config['phone'] ?></a><br>
                                <a href="mailto:<?php echo $iusm_config['email'] ?>" title="<?php echo $iusm_config['email'] ?>" aria-label="<?php echo $iusm_config['email'] ?>"><?php echo $iusm_config['email'] ?></a>
                            </p>
                        </div>

						<?php if(isset($iusm_config['button-link']) && !empty($iusm_config['button-link'])){ ?>
							<?php if(isset($iusm_config['button-label']) && !empty($iusm_config['button-label'])): ?>
                                <a class="button" href="<?php echo $iusm_config['button-link'] ?>" title="<?php echo $iusm_config['button-label'] ?>"><?php echo $iusm_config['button-label'] ?></a>
							<?php endif; ?>
						<?php } ?>

                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-3 col-pos-4">
                    <div class="social-links">
						<?php if(isset($iusm_config['social-media-title']) && !empty($iusm_config['social-media-title'])): ?>
                            <h2><?php echo $iusm_config['social-media-title'] ?></h2>
						<?php endif;?>

						<?php if(isset($iusm_config['facebook-link']) && !empty($iusm_config['facebook-link'])): ?>
                            <a class="icon-facebook" href="<?php echo $iusm_config['facebook-link'] ?>" target="_blank" title="Facebook">
                                <span class="phone-hide">Facebook</span>
                            </a>
						<?php endif;?>

						<?php if(isset($iusm_config['linkedIn-link']) && !empty($iusm_config['linkedIn-link'])): ?>
                            <a class="icon-linkedin" href="<?= $iusm_config['linkedIn-link'] ?>" target="_blank" title="LinkedIn">
                                <span class="phone-hide">LinkedIn</span>
                            </a>
						<?php endif;?>

						<?php if(isset($iusm_config['twitter-link']) && !empty($iusm_config['twitter-link'])): ?>
                            <a class="icon-twitter" href="<?php echo $iusm_config['twitter-link'] ?>" target="_blank" title="Twitter">
                                <span class="phone-hide">Twitter</span>
                            </a>
						<?php endif;?>

						<?php if(isset($iusm_config['instagram-link']) && !empty($iusm_config['instagram-link'])): ?>
                            <a class="icon-instagram" href="<?php echo $iusm_config['instagram-link'] ?>" target="_blank" title="Instagram">
                                <span class="phone-hide">Instagram</span>
                            </a>
						<?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="tagline">
                <p>Fulfilling <span>the</span> Promise</p>
            </div>
            <img class="iu-trident-logo" src="//assets.iu.edu/brand/2.x/trident-small.png" alt="Indiana University" title="Indiana University">
            <p class="copyright">
                <a href="https://www.iu.edu/copyright/index.html" title="Copyright">Copyright</a> &copy; <?php echo date("Y") ?>
                <span class="line-break">
                    The Trustees of <a href="https://www.iu.edu/" title="Indiana University"><span>Indiana University</span>&#44;</a>
                </span>
                <a class="copyright-complaints" href="https://www.iu.edu/copyright/index.html#complaints" title="Copyright Complaints">Copyright Complaints</a>
            </p>
            <p class="privacy-policy">
                <a href="/privacy" title="Privacy Policy">Privacy Notice</a> | <a href="https://accessibility.iu.edu/help/" target="_blank" title="Accessibility Help">Accessibility Help</a>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
