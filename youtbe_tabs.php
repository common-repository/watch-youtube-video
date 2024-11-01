<?php
/*
		Plugin Name: Watch Youtube Video
		Plugin URI:
		Tags: social media, YouTube, profile, tabs, social networks, bookmarks, buttons, animated, jquery, flyout, sliding
		Description: Social media tabs allows you to add YouTube subscription  to any widget area with stylish sliding tabs. Option also to have the tabs slide out from the side of the browsers.
		Author: bagelfreeze
		Version: 1.0.0
		Author URI:
*/


class youtube_expert {

	function youtube_expert(){

		if(!is_admin()){
			// Header styles
			add_action( 'wp_head', array('youtube_expert', 'header') );

			// Scripts
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'dcjqsocialtabs', youtube_expert::get_plugin_directory() . '/js/jquery.slick.tabs.1.0.js', array('jquery') );

		}
		add_action( 'wp_footer', array('youtube_expert', 'footer') );
	}

	function header(){
		//echo "\n\t";
	}

	function footer(){
		//echo "\n\t";
	}

	function get_plugin_directory(){
		return WP_PLUGIN_URL . '/youtube';
	}
};

require_once('inc/youtube_admin.php');
require_once('inc/youtube_widget.php');

if(is_admin()) {

	$youtube_expert_admin = new youtube_expert_admin();

}

// Initialize the plugin.
$dcjqsocialtabs = new youtube_expert();

// Register the widget
add_action('widgets_init', create_function('', 'return register_widget("youtube_expert_widget");'));

/* Time since function taken from WordPress.com */
if (!function_exists('wpcom_time_since')) :

function wpcom_time_since( $original, $do_more = 0 ) {
        // array of time period chunks
        $chunks = array(
                array(60 * 60 * 24 * 365 , 'year'),
                array(60 * 60 * 24 * 30 , 'month'),
                array(60 * 60 * 24 * 7, 'week'),
                array(60 * 60 * 24 , 'day'),
                array(60 * 60 , 'hour'),
                array(60 , 'minute'),
        );

        $today = time();
        $since = $today - $original;

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
                $seconds = $chunks[$i][0];
                $name = $chunks[$i][1];

                if (($count = floor($since / $seconds)) != 0)
                        break;
        }

        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

        if ($i + 1 < $j) {
                $seconds2 = $chunks[$i + 1][0];
                $name2 = $chunks[$i + 1][1];

                // add second item if it's greater than 0
                if ( (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) && $do_more )
                        $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        }
        return $print;
}
endif;

if (!function_exists('http_build_query')) :
    function http_build_query($query_data, $numeric_prefix='', $arg_separator='&'){
       $arr = array();
       foreach ( $query_data as $key => $val )
         $arr[] = urlencode($numeric_prefix.$key) . '=' . urlencode($val);
       return implode($arr, $arg_separator);
    }
endif;

?>