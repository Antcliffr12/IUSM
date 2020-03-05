
<div id="medicine-magazine">
<div id="banner-slider">
        <div id="kw_slick_slide" class="kw-slider slick-slider slick-initialized" >
            <div aria-live="polite" class="slick-list draggable">
                <div class="slick-track" style="opacity: 1;" role="listbox">
                <div class="item slick-slide" data-slick-index="0" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide00">       
                                     <img src="https://medicine.iu.edu/wp-content/uploads/2016/10/20160411_IUSMshoot2_ER_127-1-1900x950.x12687.jpg" />
                        <div class="overlay-box" id="slick-slide00">
                            <h1>Early-onset Alzheimers</h1>
                            <p>Liana Apostolova’s quest to stop a disease that stroke in the prime of life</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <!-- end of slider -->
    <section id="content">
        <div class=container>
            <div class="padding-condensed-top ">
         <h2>IU Medicine is a magazine produced by the Office of Gift Development and Alumni Relations of Indiana University School of Medicine to keep alumni and donors informed about the power of philanthropy.</h2>
            </div>
         <div class="padding-condensed-bottom">
            <div class="iu-content-grid grid-variant-b" data-columns="3" data-component="Grid Type B">
                <div class="row grid-items">
                        <div class="grid-item">
                            <div class="image">
                                <img src="https://via.placeholder.com/480x320" alt="Faces of Regeneration" />
                            </div>
                            <h1 class="title">
                                <a href="/blogs/iu-medicine-magazine/the-faces-of-regeneration/">Faces of Regeneration</a>
                            </h1>
                            <div class="description">
                            Chandan Sen, PhD, and his team explore whether skin cells and a nanochip can grow new flesh, nerve cells and organs.
                            </div>
                        </div>
                        <div class="grid-item">
                            <div class="image">
                                <img src="https://via.placeholder.com/480x320" alt="Psychology of Surgery " />
                            </div>
                            <h1 class="title">
                                <a href="/blogs/iu-medicine-magazine/the-psychology-of-surgery/">Psychology of Surgery </a>
                            </h1>
                            <div class="description">
                            Surgery residents learn mental skills to cope with stress and thrive in the operating room.                        </div>
                        </div>
                        <div class="grid-item">
                            <div class="image">
                                <img src="https://via.placeholder.com/480x320" alt="Muncie’s Medicine Mansion " />
                            </div>
                            <h1 class="title">
                                <a href="/blogs/iu-medicine-magazine/muncies-medicine-mansion/">Muncie’s Medicine Mansion </a>
                            </h1>
                            <div class="description">
                            A stately manor house in Muncie may be the finest medical student housing anywhere in the United States.                        </div>
                        </div>
                </div>  <!-- /row -->
            </div> <!-- grid -variant-b -->
        </div> <!-- /padding condensed -->
        <div class="padding-condensed-bottom">
            <h2 style="margin-bottom:0;">Philanthropy News</h2>
            <?php 
            echo render_component('blog-news-split-column', ['blog_rss_feed' => 'https://medicine.iu.edu/blogs/iu-medicine-magazine/feed/', 'blog_rss_feed_number' => '6', 'news_feed_title' => ' ',  'news_rss_feed' => 'https://medicine.iu.edu/news/tag/giving/feed/', 'news_rss_feed_number' => '1', ])
            ?>
        </div><!--/ padding condense -->
        <div class="padding-condensed-bottom">
            <?php           
             echo render_component('iu-callout-box', ['title' => 'Connect', 'body' => 'Graduates of IU School of Medicine can build lasting and meaningful connections. Follow the school of Facebook and Twitter to stay up-to-date on news and interact with current students and alumni.', 'buttons' => [['button_link' => 'https://www.facebook.com/IUMedicine/', 'button_text' => 'IU Medicine Facebook ', 'button_link_target' => '_blank'], ['button_link' => 'https://twitter.com/IUMedSchool', 'button_text' => 'IU MedSchool Twitter', 'button_link_target' => '_blank']] , 'css_classes' => 'iu-callout-box callout-normal bg-iu-cream']);
            ?>
        </div>
        <div class="padding-condensed-bottom">
            <div class="iu-split-columns-a row">
                <div class="col col-pos-1 col-xs-12 col-sm-8 col-xl-9">
                    <h2>Past Issues</h2>
                    <div class="content">
                    Catch up on news you may have missed in past issues of IU Medicine magazine.
                    </div>
                </div>
                <div class="col col-pos-2 col-xs-12 col-sm-4 col-xl-3">
                    <div class="content">
                        <ul class="link-button-list" data-component="LInk Button List">
                            <li><a href="#">Winter 2019</a></li>
                            <li><a href="#">Summer 2018</a></li>
                            <li><a href="#">Winter 218</a></li>
                        </ul>
                    </div>
                </div>
            </div><!-- iu split columns a -->
        </div>
        <div class="padding-condensed-bottom">           
        <div class="iu-content-grid grid-variant-e bg-white" data-columns="2" data-component="Grid Type E">
            <div class="row grid-items">
             <div class="grid-item">
                 <h2>Planned Giving</h2>
             <div class="image">
                <img src="https://via.placeholder.com/120x180" >
            </div>

            <h3 class="title">Tim Ueber</h3>

            <div class="subtitle">Director of Planned Giving</div>
            <div class="description">
            Tim’s extensive estate planning background includes years at a wealth management company and law firm advising families on complex financial, tax, business and estate matters.
            </div>



            </div><!-- grid item -->

            <div class="grid-item">
                <h2>Principal Gifts</h2>
             <div class="image">
                <img src="https://via.placeholder.com/120x180" >
            </div>

            <h3 class="title">Mary Maxwell</h3>

            <div class="subtitle">Director of Principal Gifts</div>
            <div class="description">
            Mary works primarily with donors who make transformational gifts that help the School significantly expand research and education initiatives.            </div>



            </div><!-- grid item -->

            </div><!-- grid items -->
        </div><!-- grid - E -->

         
        </div><!-- /padding-->
      </div><!-- /end container -->
    </section>

</div><!-- medicine magazine -->