
<section class="blog-featured-post padding-normal white">
  <div class="container">
    <div class="iu-content-grid grid-variant-g bg-white meet-our-experts" data-columns="2" data-component="Faculty Member Grid">
      <h2 class="grid-title no-margin no-padding">Popular Authors</h2>
        <div class="row grid-items">
          <div class="grid-item">
            <div class="image">
              <img src="<?php echo bloginfo("template_url")?>/assets/images/faculty-placeholder.png" alt="Jose Espada"/>
            </div>
            <div class="info-wrapper">
              <div class="info">
                <h2 class="title">
                  <a href="<?php the_permalink() ?>author/jespada/" title="Jose Espada" aria-label="Jose Espada">Jose Espada</a>
                </h2>
                <div class="subtitle">
                  Director of Student Financial Services
                </div>
                <div class="description">
                  Jose is the director of financial aid at IU School of Medicine. He speaks and blogs regularly about financing medical education.
                </div>
              </div>
            </div>
          </div>

          <div class="grid-item">
            <div class="image">
            <img src="<?=getFacultyImage($uid)?>" alt="<?= $uid ?>">        
            </div>
            <div class="info-wrapper">
              <div class="info">
                <h2 class="title">
                  <a href="<?php the_permalink() ?>author/aaecarro/" title="Aaron Carroll" aria-label="Aaron Carroll">Aaron Carroll</a>
                </h2>
                <div class="subtitle">
                  Professor of Pediatrics
                </div>
                <div class="description">
                    <?= $intro ?>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</section>
