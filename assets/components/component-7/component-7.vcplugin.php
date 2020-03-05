<?php
if( function_exists('vc_map')) {
    function sc_component_7($atts = array())
    {
        extract(shortcode_atts(array(
            'main_rss_events' => '',
            'campus_rss_events' => '',
            'department_rss_events' => '',
            'other_events' => '',
            'iu_state' => '',
            // 'campus_events_number' => '',
            // 'department_events_number' => '',
            'event_rss_feed_number' => '',

        ), $atts));

        return render_component('component-7', [
            'main_rss_events' => $main_rss_events,
            'campus_rss_events' => $campus_rss_events,     
            'department_rss_events' => $department_rss_events,
            'other_events' => $other_events,     
            'iu_state' => $iu_state,

            // 'campus_events_number' => $campus_events_number,
            // 'department_events_number' => $department_events_number,
            // test
        ]);
    }

    add_shortcode('component-7', 'sc_component_7');

    vc_map(array(
        'name' => __('Component 7'),
        'base' => 'component-7',
        'description' => __('Display an Event.'),
        'icon' => THEME_PATH . '/assets/images/icons/calendar-week.svg',
        'params' => array(
          array(
            'type' => 'dropdown',
            'heading' => __( 'Events', '' ),
            'param_name' => 'main_rss_events',
            'value' => array(
              __('None', '') => '',
              __('General', '') => '9',
            ),
            'description' => __( 'Select an event' ),
          ),

          array( 
            'type' => 'dropdown',
            'heading' => __( 'Campuses', '' ),
            'param_name' => 'campus_rss_events',
            'value' => array(
              __('None', '') => '',
              __('Bloomington', '') => '12',
              __('Evansville', '') => '39',
              __('Fort Wayne', '') => '33',
              __('Gary', '') => '17',
              __('Indianapolis', '') => '13',
              __('Muncie', '') => '40',
              __('South Bend', '') => '18',
              __('Terre Haute', '') => '41',
              __('West Lafayette', '') => '42',
            ),
            'description' => __( 'Select an event' ),
            'std' => '',
            'group' => 'Campus',
          ),

          array( 
            'type' => 'dropdown',
            'heading' => __( 'Departments', '' ),
            'param_name' => 'department_rss_events',
            'value' => array(
              __('None', '') => '',
              __('Anatomy and Cell Biology', '') => '55',
              __('Anesthesia', '') => '56',
              __('Biochemistry and Molecular Biology', '') => '57',
              __('Biostatistics', '') => '58',
              __('Cellular and Integrative Physiology', '') => '59',
              __('Dermatology', '') => '61',
              __('Emergency Medicine', '') => '62',
              __('Family Medicine', '') => '72',
              __('Internal Medicine', '') => '299',
              __('Medical and Molecular Genetics', '') => '73',
              __('Microbiology and Immunology', '') => '74',
              __('Neurological Surgery', '') => '75',
              __('Neurology', '') => '76',
              __('Obstetrics and Gynecology', '') => '77',
              __('Ophthalmology', '') => '79',
              __('Orthopaedic Surgery', '') => '80',
              __('Otolaryngology', '') => '81',
              __('Pathology and Laboratory Medicine', '') => '82',
              __('Pediatrics', '') => '42',
              __('Pharmacology and Toxicology', '') => '83',
              __('Physical Medicine and Rehabilitation', '') => '84',
              __('Psychiatry', '') => '85',
              __('Radiation Oncology', '') => '300',
              __('Radiology and Imagain Sciences', '') => '86',
              __('Surgery', '') => '41',
              __('Urology', '') => '87',
            ),
            'description' => __( 'Select an event' ),
            'std' => '',
            'group' => 'Department',
          ),
      
    


         
          array(
            'type' => 'dropdown',
            'heading' => __( 'Events', '' ),
            'param_name' => 'other_events',
            'value' => array(
              __('None', '') => '',             
              __('None', '') => '',             
              __('Breast Cancer', '') => '302',
              __('Brown Center for Immunotherapy', '') => '305',
              __('Catholic', '') => '1357',
              __('Center for Bioethics', '') => '60',        
              __('Gastroenterology and Hepatology', '') => '2324', 
              __('FAPDD', '') => '1717', 
              __('IMPRS', '') => '1362',
              __('IUSMSIGs', '') => '910',
              __('Indiana Center for Liver Research', '') => '2323',              
              __('Indiana Center for Regenerative Medicine and Engineering', '') => '310',
              __('Indiana Clinical and Translational Sciences', '') => '306',
              __('Center for Computational Biology and Bioinformatics','') => '301',
              __('Center for Diabetes and Metabolic Diseases', '') => '304',
              __('Melvin and Bren Simon Cancer Center', '') => '303',
              __('MSTP', '') => '1361',
              __('Music', '') => '1359',
              __('Musculoskeletal Health', '') => '307',            
              __('Residency', '') => '1369',
              __('Stark Neurosciences Research Institute', '') => '308',           
              __('Wells Center', '') => '309',      
            ),
            'description' => __( 'Select an event' ),
            'std' => '',
            'group' => 'All Other Events',
          ),
          array(
            'type' => 'dropdown',
            'heading' => __( 'Events', '' ),
            'param_name' => 'iu_state',
            'value' => array(
              __('None', '') => '',
              __('Diversity', '') => 'Diversity',
            ),
            'description' => __( 'Select an event' ),
            'group' => 'Statewide Events',
          ),
     
        ),
    ));
}

