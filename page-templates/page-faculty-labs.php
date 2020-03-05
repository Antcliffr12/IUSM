<?php
/*
/* Template Name: Faculty Labs
*/


$path = get_page_uri($post->ID);
global $current_path;

$current_path = WP_SITEURL . '/' . trim($path, '/') . '/';
$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

$subnav_root_path = '/'. (count($segments) > 0 ? $segments[0] : ''); // Default to second-level page as menu root
//1 on local 0 on DEV and LIVE

if (count($segments) > 2 && $segments[0] === 'research' && $segments[1] === 'centers-institutes') {
    $section_switcher = render_component('institutes-switcher', ['path' => $path]);
    $subnav_root_path = '/research/centers-institutes/' . $segments[2];
}
if (count($segments) > 1) {
    if ($segments[0] === 'departments') {
        $section_switcher = render_component('department-switcher', ['path' => $path]);
        $subnav_root_path = '/departments/' . $segments[1];
    } elseif ($segments[0] === 'campuses') {
        $section_switcher = render_component('campus-switcher', ['path' => $path]);
        $subnav_root_path = '/campuses/' . $segments[1];
    }
}

global $extra_body_classes;
$extra_body_classes = 'page-layout-two-column';
get_header();
get_template_part('partials/header-content');
?>

<section id="content">
    <div class="container">
        <div class="row">

        <div id="region-aux1" class="col-xs-12 col-md-3">
                <?= isset($section_switcher) ? $section_switcher : ''; ?>
                <div id="sidebar-nav" class="collapse-mobile" data-current="<?= $current_path; ?>">
                    <h2 class="menu-toggle desktop-hide">In This Section:</h2>
                    <nav role="navigation" aria-label="Sidebar Navigation" class="menu-wrapper">
                        <ul class="menu" data-menudepth="0">
                      
                        <?php
                        if (!is_null(DEFAULT_SIDEBAR_MENU_ID) && !empty(DEFAULT_SIDEBAR_MENU_ID)) {
                            wp_nav_menu(array(
                                'menu' => DEFAULT_SIDEBAR_MENU_ID,
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'walker' => new WalkerNavSidebar(),
                                'sub_menu' => true,
                                'subnav_root_path' => $subnav_root_path,
                            ));
                        }
                        ?>
                        
                        </ul>
                    </nav>
                </div>
            </div>



			<div id="region-main" class="col-xs-12 col-md-9">
        <h1>Faculty Labs</h1>
        <p>
        Successful biomedical research demands collaboration among scientists with varying specialties. Faculty throughout IU School of Medicine's 26 academic departments work together to advance knowledge and treatment for patients in the world's most critical areas of medicine. </p>
        <div class="faculty-labs-search testing">
          <div class="faculty-wrap">

          <h2>Find a Faculty Lab</h2>
   
          <form role="search" method="get" id="searchTypes" action="<?php the_permalink(); ?>">

            <div class="search-faculty-dropdown"> 
            <?php 
            $selected = empty($_GET['research']) ? '' : $_GET['research'];

            $args = array(
                'taxonomy' => 'research',
                'hide_empty' => 0,
                'parent' => 0,
                'echo' => 1,
                'name' => 'research',
                'show_option_none' => __( 'Research Area' ),
                'option_none_value' => '',
                'selected' =>$selected,
                'orderby'           => 'name',

                'order' => 'ASC',
                'value_field'	     => 'slug',
            );
            wp_dropdown_categories( $args );        
            ?>
            </div>
            <?php 
              $type = isset($_GET['research']) ? $_GET['research'] : '';
              $args = array(
                'orderby'           => 'name',
              'order'             => 'ASC',
              'hide_empty'        => true,
              'parent' => 0,
              );
              $taxonomyName = 'research';

              $parent_terms = get_terms( $taxonomyName, array( $args) );

              $sub_selected = empty($_GET['subspecialty']) ? '' : $_GET['subspecialty'];
              ?>
            <?php 
            foreach($parent_terms as $pterm){
              if($type === $pterm->slug){
                ?>
                 <div class="search-subfaculty-dropdown" style="display:inline-block !important;"> 
                <?php 
                $terms = get_terms( $taxonomyName, array( 'parent' => $pterm->term_id, 'orderby' => 'slug', 'hide_empty' => false ) );
                if(!empty($terms)){
                  
                $args = array(
                  'child_of' => $pterm->term_id,
                  'taxonomy' => $pterm->taxonomy,
                  'hide_empty' => true,
                  'show_option_none' => __( 'Please Select Subspecialty' ),
                  'option_none_value' => '',
                  'selected' =>$sub_selected,
                  'orderby'           => 'title',

                  'order' => 'ASC',
                  'value_field'	     => 'slug',
                  'name' => 'subspecialty',    
                  ); 
                   wp_dropdown_categories( $args );
                }
                ?>
              </div>
                <?php 
              }else{
                ?>
                <div class="search-subfaculty-dropdown" style="display:none;"> </div>
                <?php 
              }
            }                  
          
            ?>
              
            <input type="submit" id="searchsubmit" style="display:none;" value="" />
          </form>
          <form role="search" method="get" id="searchFacultyLabs" action="<?php the_permalink(); ?>">
          
          <input type="text" size="30" name="key" id="keyword" placeholder="Search">
          <input type="hidden" name="post_type" value="faculty-labs" /> 
          <span class="search-submit"><input type="submit" value="Search" /></span>

          </form>
          </div>
        </div>

        <?php 
        $type = isset($_GET['research']) ? $_GET['research'] : '';
        $key = isset($_GET['key']) ? $_GET['key'] : '';
        $child_types = isset($_GET['subspecialty']) ? $_GET['subspecialty'] : '';

        echo getSearchResults($type, $key, $child_types);


        function getSearchResults($type, $key, $child_types){

          global $post;

                      

        

          //page load, load every posts
          if($type === '' && $key === ''){
        

           $query = new WP_Query(array(

                'post_type' => 'faculty-labs',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby'           => 'title',
               'order'             => 'ASC',

            ));

            while ($query->have_posts()) {
                $query->the_post();
                  echo render_html( $post);
            }
            wp_reset_query();
          }// end if empty


        global $wpdb;
        //gets parent posts
      if(!empty($type) && empty($child_types)){

      $cat_terms = get_terms(
                array('research'),
                array(
                        'hide_empty'    => false,
                        
                    )
            );
            if($cat_terms){
              $args = array(
              'post_type'             => 'faculty-labs',
              'posts_per_page'        => -1,
              'post_status'           => 'publish',
              'orderby'       => 'title',
              'order'         => 'ASC',
              'tax_query'             => array(
                array(
                    'taxonomy' => 'research',
                    'field'    => 'slug',
                    'terms'    => $type,
                ),
            ),
          );
            $query = new WP_Query( $args );

        if( $query->have_posts() ) :
            while( $query->have_posts() ) : $query->the_post();

            echo render_html( $post);

            endwhile;
        endif;
        wp_reset_postdata(); //important
        }//end of if
        //gets the child posts of child categories
      }elseif(!empty($type) && !empty($child_types)){
        
        $cat_terms = get_terms(
                  array('research'),
                  array(
                          'hide_empty'    => false,
                          
                      )
              );
              if($cat_terms){
              $args = array(
              'post_type'             => 'faculty-labs',
              'posts_per_page'        => -1,
              'post_status'           => 'publish',
              'orderby'       => 'title',
              'order'         => 'ASC',
              'tax_query'             => array(
                  array(
                      'taxonomy' => 'research',
                      'field'    => 'slug',
         	             'terms'    => $child_types
                        ),
                    ),
                  );
              $query = new WP_Query( $args );

          if( $query->have_posts() ) :
              while( $query->have_posts() ) : $query->the_post();

                  echo render_html( $post);

              endwhile;
          endif;
          wp_reset_postdata(); //important
      }
    }//end of else if
    //gets instrcutor different query
  elseif(!empty($key)){

    $key = esc_attr(trim($key));

    $querystr = "SELECT DISTINCT p.ID, p.post_title, p.post_content
    FROM
    wp_posts p
    INNER JOIN wp_term_relationships tr_type ON p.ID=tr_type.object_id
    INNER JOIN wp_term_taxonomy tax_type ON tr_type.term_taxonomy_id = tax_type.term_taxonomy_id
    INNER JOIN wp_terms type_terms ON tax_type.term_id = type_terms.term_id
    LEFT JOIN wp_postmeta pm1 ON (pm1.post_id = p.ID AND pm1.meta_key = '_faculty_notice')
    LEFT JOIN wp_postmeta pm2 ON (pm2.post_id = p.ID AND pm2.meta_key = '_faculty_id_notice')
    LEFT JOIN wp_postmeta pm3 ON (pm3.post_id = p.ID AND pm3.meta_key = '_faculty_url_notice')
    WHERE p.post_type = 'faculty-labs'  
    AND (tax_type.taxonomy = 'research' OR tax_type.taxonomy = 'department')
   
    AND (p.post_title LIKE '%" . $key . "%' OR type_terms.name LIKE '%" . $key . "%' OR pm1.meta_value LIKE '%" . $key . "%' OR p.post_content LIKE '%" . $key . "%' )
    ORDER BY
    p.post_title";
     $pageposts = $wpdb->get_results($querystr, OBJECT);

    if($pageposts) :
      global $post;
      foreach($pageposts as $post) :
        //setup_postdata($post);    
        render_html($post);

      endforeach;


    endif;


  }
}// end getSearchResults
function render_html($post){
  ?>
  <div class="faculty-labs">
          <div class="faculty-labs-wrap">
            <div class="faculty-lab-image">
              <?php
              $faculty_id = get_post_meta($post->ID, '_faculty_id_notice', true );



                ?>
                <img src="<?=getFacultyImage($faculty_id)?>" >
            </div><!-- image -->
            <div class="faculty-lab-text">
              <?php
             $lastname = strtok(get_the_title(),  ' ');
             $lastname = mb_strtolower($lastname);
             $url = get_post_meta( $post->ID, '_faculty_url_notice', true );
             ?>
             <h2 class="title"><a href="<?= site_url() . '/research/faculty-labs/' . $url ?>" /><?= get_the_title(); ?></a></h2>
             
            <?php echo wp_trim_words( $post->post_content, 60, '...' ); ?>
            </div><!-- faculty lab text -->
            <div class="faculty-lab-contact">
              <div class="contact-box">
                <div class="contact-box-wrap">
                  <div class="investigator">
                    <?php

                    $faculty_name = get_post_meta( $post->ID, '_faculty_notice', true );
                    $faculty_id = get_post_meta($post->ID, '_faculty_id_notice', true );
                    $checkBox = get_post_meta($post->ID, 'checkValue', true );

                    
                      $parts = array();


                        $name = trim($faculty_name);
                        $name=preg_replace('/^([^,]*).*$/', '$1', $name);
                        $name =strtr($name, array('.' => '', ',' => ''));

                        $url_name = str_replace(' ', '-', strtolower($name));

                    ?>
                    <h2>Principal Investigator</h2>
                   <a href="/faculty/<?= $faculty_id ?>/<?= $url_name ?>"><?= $faculty_name ?></a>
                 </div><!-- investigator -->
                 <div class="department">
                    <h2>Department</h2>
                    <?php
                //    $departments = get_the_term_list( $post->ID, 'department', '', ', ' );
                    $department = wp_get_post_terms($post->ID, 'department', array("fields" => "all"));
                    //print_r($departments);
                    // $departments = wp_get_post_terms($post->ID, 'department', array("fields" => "all"));
                    // Do switch for each departments category
                    foreach($department as $departments){
                      switch($departments->name){
                        case "Anatomy and Cell Biology":
                        $link = '/departments/anatomy-cell-biology/';
                        break;

                        case "Anesthesia":
                        $link = 'departments/anesthesia/';
                        break;
                        case "Biochemistry and Molecular Biology":
                        $link = '/departments/biochemistry-molecular-biology/';
                        break;
                        case "Biostatistics":
                        $link = '/departments/biostatistics/';
                        break;
                        case "Cellular and Integrative Physiology":
                        $link = '/departments/physiology/';
                        break;
                        case "Dermatology":
                        $link = '/departments/dermatology/';
                        break;

                        case "Emergency Medicine":
                        $link = '/departments/emergency-medicine/';
                        break;

                        case "Family Medicine":
                        $link = '/departments/family-medicine/';
                        break;

                        case "Medical and Molecular Genetics":
                        $link = '/departments/genetics/';
                        break;

                        case "Medicine":
                        $link = '/departments/internal-medicine/';
                        break;

                        case "Neurological Surgery":
                        $link = '/departments/neurological-surgery/';
                        break;

                        case "Neurology":
                        $link = '/departments/neurology/';
                        break;

                        case "Obstetrics and Gynecology":
                        $link = '/departments/obgyn/';
                        break;

                        case "Ophthalmology":
                        $link = '/departments/ophthalmology/';
                        break;

                        case "Pathology and Laboratory Medicine":
                        $link = '/departments/pathology/';
                        break;

                        case "Orthopaedic Surgery":
                        $link = '/departments/orthopaedic-surgery/';
                        break;

                        case "Otolaryngology":
                        $link = '/departments/otolaryngology/';
                        break;

                        case "Pediatrics":
                        $link = '/departments/pediatrics/';
                        break;

                        case "Physical Medicine and Rehabilitation":
                        $link = '/departments/physiatry/';
                        break;

                        case "Psychiatry":
                        $link = '/departments/psychiatry/';
                        break;


                        case "Radiology and Imaging Sciences":
                        $link = '/departments/radiology/';
                        break;

                        case "Radiation Oncology":
                        $link = '/departments/radiation-oncology/';
                        break;

                        case "Surgery":
                        $link = '/departments/surgery/';
                        break;

                        case "Urology":
                        $link = '/departments/urology/';
                        break;

                        case "Pharmacology and Toxicology":
                        $link = '/departments/pharmacology-toxicology/';
                        break;

                        case "Microbiology and Immunology":
                        $link = '/departments/microbiology-immunology';
                        break;


                        default:
                        $link = "/departments";
                      }//end of switch
                    ?>
                     <a href="<?= $link ?>"><?php echo $departments->name; ?></a>
                   <?php }//end of freach ?>
                  </div><!-- department -->
                  <div class="labHours">
                       
                  <?php     
                  if($checkBox == 'on'){
                    echo '<h2>Accepting Students</h2>';
                  }

                    ?>
                    </h2>
                  </div>
                </div><!-- contacnt box wrap -->
              </div><!-- contact box -->
            </div><!-- faculut lab contact -->
          </div><!-- faculty labs wrap -->
        </div><!-- faculty -labs -->
  <?php
}//end of render




        ?>
       
			</div>
		</div>
	</div>
</section>
<?php 

get_footer(); ?>
