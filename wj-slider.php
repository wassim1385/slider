<?php

/**
*Plugin Name: WJ Slider
*Plugin URI: https://wordpress.org/mv-slider
*Description: My plugin's description
*Version: 1.0
*Requires at least: 5.6
*Author: Wassim Jelleli
*Author URI: https://www.linkedin.com/in/wassim-jelleli/
*Text Domain: wj-slider
*Domain Path: /languages
*/

if ( ! defined ( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'WJ_Slider' ) ) {

    class WJ_Slider {

        public function __construct() {

            $this->define_constants();
            require_once( WJ_SLIDER_PATH . 'functions/functions.php' );

            add_action( 'admin_menu', array( $this, 'add_menu' ) );

            //Require the CPT Class
            require_once( WJ_SLIDER_PATH . 'cpt/class.wj-slider-cpt.php' );
            $wj_slider_cpt = new WJ_Slider_Post_Type();

            //Require the Settings Class
            require_once( WJ_SLIDER_PATH . 'class.wj-slider-settings.php' );
            $wj_slider_settings = new WJ_Slider_Settings();

            //Require the Shortcode Class
            require_once( WJ_SLIDER_PATH . 'shortcode/class.wj_slider_shortcode.php' );
            $wj_slider_shortcode = new WJ_Slider_Shortcode();

            add_action( 'wp_enqueue_scripts', array( $this, 'wj_register_scripts' ), 999 );

        }

        public function define_constants() {

            define( 'WJ_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
            define( 'WJ_SLIDER_URL', plugin_dir_url( __FILE__ ) );
            define( 'WJ_SLIDER_VERSION', '1.0.0' );
        }

        public static function activate() {
            update_option( 'rewrite_rules', '' );
        }
        public static function deactivate() {
            flush_rewrite_rules();
            unregister_post_type( 'wj-slider' );
        }
        public static function uninstall() {
            
        }

        public function add_menu() {

            add_menu_page(
                'MV Slider Options',
                'MV Slider',
                'manage_options',
                'wj_slider_admin',
                array( $this, 'wj_slider_settings_page' ),
                'dashicons-images-alt2',
                100
            );

            add_submenu_page(
			'wj_slider_admin',
            'Manage Slides',
            'Manage Slides',
            'manage_options',
            'edit.php?post_type=wj-slider',
            null,
            null
            );

            add_submenu_page( 'wj_slider_admin',
            'Add New Slide',
            'Add New Slide',
            'manage_options',
            'post-new.php?post_type=wj-slider',
            null,
            null
            );
        }

        public function wj_slider_settings_page() {

            if( ! current_user_can( 'manage_options' ) )
                return;

            if( isset( $_GET['settings-updated'] ) ) 
                add_settings_error( 'wj_slider_options', 'wj_slider_message', 'Settings saved', 'success' );

            settings_errors( 'wj_slider_options' );
            require( WJ_SLIDER_PATH . 'views/settings-page.php' );
        }

        public function wj_register_scripts() {
            wp_register_script( 'wj-flex-slider-jq', WJ_SLIDER_URL . 'vendor/flexslider/jquery.flexslider-min.js', array( 'jquery'), WJ_SLIDER_VERSION, true );
            wp_register_style( 'wj-flex-slider-css', WJ_SLIDER_URL . 'vendor/flexslider/flexslider.css', array(), WJ_SLIDER_VERSION, 'all' );
            wp_register_style( 'wj-slider-front-css', WJ_SLIDER_URL . 'assets/css/frontend.css', array(), WJ_SLIDER_VERSION, 'all' );
        }

    }//endClass
}//Endif

if( class_exists( 'WJ_Slider' ) ) {

    register_activation_hook( __FILE__, array( 'WJ_Slider', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'WJ_Slider', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'WJ_Slider', 'uninstall' ) );

    $wj_slider = new WJ_Slider();
}
