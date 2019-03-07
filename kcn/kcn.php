<?php
/*
Plugin Name: Kannada Chanakya Neeti
Plugin URI: https://www.sharadhiinfotech.com/wordpress-plugins-kannada-chankya-neeti/
Description: This plugin creates a widget which Show a random kannada verse from Chanakya Niti written by Chanakya on your website!. You can add this widget to any widgetized areas, such as sidebars.
Author: Raghavendra Uppunda
Version: 1.0.3
Author URI: https://www.sharadhiinfotech.com/
*/

/*  This file is part of Kannada Chanakya Neeti plugin, developed by Raghavendra Uppunda (email: contact@sharadhiinfotech.com)

	Chanakya Neeti is a collection of aphorisms, said to be selected by Chanakya from the various shastras.

    Kannada Chanakya Neeti is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Kannada Chanakya Neeti is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Kannada Chanakya Neeti plugin. If not, see <http://www.gnu.org/licenses/>.
*/

function kcn_get_neeti() {
	$kcnfile = plugins_url( 'kcn.txt' , __FILE__ );
	$lines = file("$kcnfile"); 

	// Randomly choose a verse
	return wptexturize( $lines[ mt_rand( 0, count( $lines ) - 1 ) ] );
}

function kcn_show_neeti() {
	$kcn = kcn_get_neeti();
	
	echo "<p id='kcn' class='kcn'>$kcn</p>";
}

function kcn_scripts() {
    wp_register_style('kcn-css', plugins_url('kcn.css',__FILE__ ));
    wp_enqueue_style('kcn-css');
  //  wp_register_script( 'kcn-js', plugins_url('kcn.js',__FILE__ ));
   // wp_enqueue_script('kcn-js');
}

add_action( 'wp_enqueue_scripts','kcn_scripts');


class Kannada_Chanakya_Neeti_Widget extends WP_Widget {
			
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'kannada_chanakya_neeti', 
			'description' => __('Show a random kannada verse from Chanakya Niti written by Chanakya on your website!')
		);
    	parent::__construct('kannada-chanakya-neeti', __('Kannada Chanakya Neeti'), $widget_ops);
	}
	
	function widget($args, $instance) {
           
			extract( $args );
		
			$title = apply_filters( 'widget_title', empty($instance['title']) ? ' ಚಾಣಕ್ಯ ನೀತಿ ' : $instance['title'], $instance, $this->id_base);	
			
			
			echo $before_widget;
			
			
			// Widget title
			
			echo $before_title;
			
			echo $instance["title"];
			
			echo $after_title;
			
			
			// Call show_kcn function
			
    			kcn_show_neeti();

		echo $after_widget;

	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
	     
        		return $instance;
	}
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : ' ಚಾಣಕ್ಯ ನೀತಿ ';
		
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
             
<?php
	}
}

function kcn_register_widgets() {
	register_widget( 'Kannada_Chanakya_Neeti_Widget' );
}

add_action( 'widgets_init', 'kcn_register_widgets' );

// Donate link on manage plugin page
function kcn_pluginspage_links( $links, $file ) {

$plugin = plugin_basename(__FILE__);

// create links
if ( $file == $plugin ) {
return array_merge(
$links,
array( '<a href="https://www.sharadhiinfotech.com/" target="_blank" title="Contact for Help/Support ">Support</a>',
 )
);
			}
return $links;

	}
add_filter( 'plugin_row_meta', 'kcn_pluginspage_links', 10, 2 );
?>
