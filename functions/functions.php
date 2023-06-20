<?php

    if( ! class_exists( 'wj_slider_options' ) ) {

        function wj_slider_options() {

            $show_bullets = isset( WJ_Slider_Settings::$options[ 'wj_slider_bullets' ] ) && WJ_Slider_Settings::$options[ 'wj_slider_bullets' ] == 1 ? true : false;
            wp_enqueue_script( 'wj-flex-slider-js', WJ_SLIDER_URL . 'vendor/flexslider/flexslider.js', array( 'jquery' ), WJ_SLIDER_VERSION, true );
            wp_localize_script( 'wj-flex-slider-js', 'SLIDER_OPTIONS', array(
                'controlNav' => $show_bullets
            ) );
        }
    }
    