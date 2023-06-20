<?php

if( ! class_exists( 'WJ_Slider_Shortcode' ) ) {

    class WJ_Slider_Shortcode {

        public function __construct() {

            add_shortcode( 'wj_slider', array( $this, 'add_shortcode' ) );
        }

        public function add_shortcode( $atts = array(), $content = null, $tag =''  ) {

            $atts = array_change_key_case( (array) $atts, CASE_LOWER );
            extract( shortcode_atts(
                array(
                    'id' => '',
                    'oder_by' => 'date'
                ),
                $atts,
                $tag
            ) );

            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id ) );
            }
            
            ob_start();
            require( WJ_SLIDER_PATH . 'views/wj-slider_shortcode.php' );
            wp_enqueue_script( 'wj-flex-slider-jq' );
            wp_enqueue_style( 'wj-flex-slider-css' );
            wp_enqueue_style( 'wj-slider-front-css' );
            wj_slider_options();
            return ob_get_clean();
        }
    }
}