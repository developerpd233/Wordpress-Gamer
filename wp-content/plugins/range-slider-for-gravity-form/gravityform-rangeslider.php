<?php 
/**
* Plugin Name: Range Slider for Gravity Form
* Description: This plugin allows create Rangeslider for gravityfrom.
* Version: 1.0
* Author: Ocean Infotech
* Author URI: https://www.xeeshop.com
* Copyright: 2020
* Text Domain: range-slider-for-gravity-form
* Domain Path: /languages 
*/



if (!defined('ABSPATH')) {
    die('-1');
}
if (!defined('OCRSGF_PLUGIN_NAME')) {
    define('OCRSGF_PLUGIN_NAME', 'Range Slider Gravity Form');
}
if (!defined('OCRSGF_PLUGIN_VERSION')) {
    define('OCRSGF_PLUGIN_VERSION', '2.0.0');
}
if (!defined('OCRSGF_PLUGIN_FILE')) {
    define('OCRSGF_PLUGIN_FILE', __FILE__);
}
if (!defined('OCRSGF_PLUGIN_DIR')) {
    define('OCRSGF_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('OCRSGF_BASE_NAME')) {
    define('OCRSGF_BASE_NAME', plugin_basename(OCRSGF_PLUGIN_FILE));
}
if (!defined('OCRSGF_DOMAIN')) {
    define('OCRSGF_DOMAIN', 'range-slider-for-gravity-form');
}
if (!class_exists('OCRSGF')) {

  	class OCRSGF {
        protected static $OCRSGF_instance;
  
        function includes() {
            include_once('admin/gravity_rangeslider.php');
        }

        function init() { 
            add_action( 'wp_enqueue_scripts',array($this,'enqueue_custom_script'), 9000);  
            add_action('admin_enqueue_scripts', array($this, 'OCRSGF_load_admin_script_style')); 
            add_filter( 'gform_noconflict_styles', array($this, 'register_style') );     
            add_filter( 'plugin_row_meta', array( $this, 'OCRSGF_plugin_row_meta' ), 10, 2 );
        }

        function register_style( $styles ) {
            $styles[] = 'OCRSGF_admin_css';
            return $styles;
        }

        function OCRSGF_plugin_row_meta( $links, $file ) {
            if ( OCRSGF_BASE_NAME === $file ) {
                $row_meta = array(
                  'rating'    =>  ' <a href="https://www.xeeshop.com/how-to-setup-range-slider-for-gravity-form/" target="_blank">Documentation</a> | <a href="https://www.xeeshop.com/support-us/?utm_source=aj_plugin&utm_medium=plugin_support&utm_campaign=aj_support&utm_content=aj_wordpress" target="_blank">Support</a> | <a href="https://wordpress.org/support/plugin/range-slider-for-gravity-form/reviews/?filter=5" target="_blank"><img src="'.OCRSGF_PLUGIN_DIR.'/includes/image/star.png" class="ocrsgf_rating_div"></a>',
                );
                return array_merge( $links, $row_meta );
            }
            return (array) $links;
        }

        function OCRSGF_load_admin_script_style(){
            wp_enqueue_style( 'OCRSGF_admin_css', OCRSGF_PLUGIN_DIR . '/includes/css/admin_style.css', false, '1.0.0' );
        }

        function enqueue_custom_script() {
            //wp_enqueue_script( 'custom_script_jquery', OCRSGF_PLUGIN_DIR.'/includes/js/jquery.min.js');
            wp_enqueue_style( 'OCGFRS-style-css', OCRSGF_PLUGIN_DIR . '/includes/css/style.css', false, '2.0.0' );
            wp_enqueue_script( 'OCGFRS-jquery-ui-js', OCRSGF_PLUGIN_DIR .'/includes/js/jquery-ui.js', false, '2.0.0' );
            wp_enqueue_script( 'OCGFRS-jquery-ui-touch-punch-js', OCRSGF_PLUGIN_DIR .'/includes/js/jquery.ui.touch-punch.min.js', false, '2.0.0' );
            wp_enqueue_style( 'OCGFRS-jquery-ui-css', OCRSGF_PLUGIN_DIR .'/includes/js/jquery-ui.css', false, '2.0.0' );  
            wp_enqueue_style( 'OCGFRS-jquery-ui-slider-pips-css', OCRSGF_PLUGIN_DIR .'/includes/js/jquery-ui-slider-pips.css', false, '2.0.0' ); 

            wp_enqueue_script( 'OCGFRS-jquery-ui-slider-pips-js', OCRSGF_PLUGIN_DIR .'/includes/js/jquery-ui-slider-pips.js', false, '2.0.0' );
            wp_enqueue_script( 'custom_script', OCRSGF_PLUGIN_DIR.'/includes/js/front.js');
        }
          //Plugin Rating
        public static function do_activation() {
            set_transient('ocgfrs-first-rating', true, MONTH_IN_SECONDS);
        }
        public static function OCRSGF_instance() {
            if (!isset(self::$OCRSGF_instance)) {
                self::$OCRSGF_instance = new self();
                self::$OCRSGF_instance->init();
                self::$OCRSGF_instance->includes();
            }
            return self::$OCRSGF_instance;
        }
	}
	add_action('plugins_loaded', array('OCRSGF', 'OCRSGF_instance'));
    register_activation_hook(OCRSGF_PLUGIN_FILE, array('OCRSGF', 'do_activation'));
}


add_action( 'plugins_loaded', 'ocrsgf_load_textdomain' );
function ocrsgf_load_textdomain() {
    load_plugin_textdomain( 'range-slider-for-gravity-form', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}

function ocrsgf_load_my_own_textdomain( $mofile, $domain ) {
    if ( 'range-slider-for-gravity-form' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
        $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
        $mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
    }
    return $mofile;
}
add_filter( 'load_textdomain_mofile', 'ocrsgf_load_my_own_textdomain', 10, 2 );