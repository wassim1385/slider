<?php

if( ! class_exists( 'WJ_Slider_Settings' ) ) {

    class WJ_Slider_Settings {

        public static $options;

        public function __construct() {

            self::$options = get_option( 'wj_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }

        public function admin_init() {

            register_setting( 'wj_slider_group', 'wj_slider_options', array( $this, 'wj_slider_validate' ) );

            add_settings_section(
                'wj_slider_main_section',
                'How does it work?',
                null,
                'wj_slider_page1'
            );

            add_settings_field(
                'wj_slider_shortcode',
                'Shortcode',
                array( $this, 'wj_slider_shortcode_callback' ),
                'wj_slider_page1',
                'wj_slider_main_section'
            );

            add_settings_section(
                'wj_slider_second_section',
                'Other Plugin Options',
                null,
                'wj_slider_page2'
            );

            add_settings_field(
                'wj_slider_title',
                'Title',
                array( $this, 'wj_slider_title_callback' ),
                'wj_slider_page2',
                'wj_slider_second_section'
            );

            add_settings_field(
                'wj_slider_bullets',
                'Display Bullets',
                array( $this, 'wj_slider_bullets_callback' ),
                'wj_slider_page2',
                'wj_slider_second_section'
            );

            add_settings_field(
                'wj_slider_style',
                'Slider style',
                array( $this, 'wj_slider_style_callback' ),
                'wj_slider_page2',
                'wj_slider_second_section'
            );

            add_settings_field(
                'wj_slider_overlay_opacity',
                'Slides overlay Opacity',
                array( $this, 'wj_slider_overlay_opacity_callback' ),
                'wj_slider_page2',
                'wj_slider_second_section'
            );

        }

        public function wj_slider_shortcode_callback() {

            ?>
                <span>Use the schortcode [wj_slider] to display the slider in any page/post/widget</span>
            <?php
        }

        public function wj_slider_title_callback() {
            ?>
                <input
                type="text"
                name="wj_slider_options[wj_slider_title]"
                id="wj_slider_title"
                value="<?php echo isset( self::$options['wj_slider_title'] ) ? self::$options['wj_slider_title'] : '' ?>"
                >
            <?php
        }

        public function wj_slider_bullets_callback() {
            ?>
                <input
                type="checkbox"
                name="wj_slider_options[wj_slider_bullets]"
                id="wj_slider_bullets"
                value="1"
                <?php
                    if( isset( self::$options['wj_slider_bullets'] ) ) {
                        checked( "1", self::$options['wj_slider_bullets'], true );
                    }
                ?>
                />
                <label for="wj_slider_bullets">Whatever display bullets or not</label>
            <?php
        }

        public function wj_slider_style_callback() {
            ?>
                <select
                name="wj_slider_options[wj_slider_style]"
                id="wj_slider_style">
                <option value="style-1"
                    <?php isset( self::$options['wj_slider_style'] ) ? selected( 'style-1', self::$options['wj_slider_style'], true ) : ''; ?>>Style-1</option>
                    <option value="style-2"
                    <?php isset( self::$options['wj_slider_style'] ) ? selected( 'style-2', self::$options['wj_slider_style'], true ) : ''; ?>>Style-2</option>
                </select>
            <?php
        }

        public function wj_slider_overlay_opacity_callback() {
            ?>
                <label for="wj_slider_overlay_opacity">Opacity (between 0 and 100%)</br>if the opacity is 100% the slide's image will not be visible.</label>
                <input
                type="range"
                id="wj_slider_overlay_opacity"
                name="wj_slider_options[wj_slider_overlay_opacity]"
                min="0"
                max="100"
                step="10"
                value="<?php echo isset( self::$options['wj_slider_overlay_opacity'] ) ? self::$options['wj_slider_overlay_opacity'] : 0; ?>"
                >
            <?php
        }

        public function wj_slider_validate( $input ) {

            $new_input = array();

            foreach( $input as $key=> $value ) {
                switch( $key ) {
                    case 'wj_slider_title' :
                        if( empty( $value ) ) {
                            add_settings_error( 'wj_slider_options', 'wj_slider_message', 'The title field can not be empty', 'error' );
                            $value = 'Please enter a title';
                        }
                        $new_input[$key] = sanitize_text_field( $value);
                    break;
                    case 'wj_slider_bullets' :
                        $new_input[$key] = sanitize_text_field( $value);
                    break;
                    case 'wj_slider_style' :
                        $new_input[$key] = sanitize_text_field( $value);
                    break;
                    case 'wj_slider_overlay_opacity' :
                        $new_input[$key] = sanitize_text_field( $value);
                    break;
                }
            }

            return $new_input;
        }

    }//EndClass
}//Endif
