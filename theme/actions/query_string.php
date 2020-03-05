<?php


// Allow WordPress search to access "q" in the query string
function ds_whitelist_new_search_parameter( $allowed_query_vars ) {
    $allowed_query_vars[] = 'q';
    return $allowed_query_vars;
}
add_filter('query_vars', 'ds_whitelist_new_search_parameter' );


// populate s parameter with value of search
function ds_swap_search_parameter($query_string) {

    $query_string_array = array();

    // convert the query string to an array
    parse_str($query_string, $query_string_array);

    // if "search" is in the query string
    if(isset($query_string_array['q'])){
        $query_string_array['s'] = $query_string_array['q']; // replace "s" with value of "search"
        unset($query_string_array['q']); // delete "search" from query string
    }

    return http_build_query($query_string_array, '', '&'); // Return our modified query variables
}
add_filter('query_string', 'ds_swap_search_parameter');