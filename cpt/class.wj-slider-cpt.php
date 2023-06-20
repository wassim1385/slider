<?php

if( ! class_exists( 'WJ_Slider_Post_Type' ) ) {

    class WJ_Slider_Post_Type {

        public function __construct() {

            add_action( 'init', array( $this, 'create_post_type' ) ); // To create a custom post type you need to fire a callback function with the 'init' action hook

            //ADD metaboxes to our CPT
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

            //Saving metabox's data
            add_action( 'save_post', array( $this, 'save_post' ) );

            //Adding values to the post type table in the admin area
            add_filter( 'manage_wj-slider_posts_columns', array($this, 'wj_slider_posts_columns' ) );

            add_action( 'manage_wj-slider_posts_custom_column',array( $this, 'wj_slider_custom_columns' ), 10, 2 );

            add_filter( 'manage_edit-wj-slider_sortable_columns', array( $this, 'wj_slider_sortable_columns' ) );
        }

        public function wj_slider_posts_columns( $columns ) {

            $columns['wj_slider_link_text'] = esc_html__( 'Link Text', 'wj-slider' );
            $columns['wj_slider_link_url'] = esc_html__( 'Link URL', 'wj-slider' );
            return $columns;
        }

        public function wj_slider_custom_columns( $column, $post_id ) {

            switch( $column ){
                case 'wj_slider_link_text':
                    echo esc_html( get_post_meta( $post_id, 'wj_slider_link_text', true ) );
                break;
                case 'wj_slider_link_url':
                    echo esc_url( get_post_meta( $post_id, 'wj_slider_link_url', true ) );
                break;                
            }
        }

        public function wj_slider_sortable_columns( $columns ){
            $columns['wj_slider_link_text'] = 'wj_slider_link_text';
            return $columns;
        }

        public function create_post_type(){

            register_post_type(
                'wj-slider',
                array(
                    'label' => 'Slider',
                    'description'   => 'Sliders',
                    'labels' => array(
                        'name'  => 'Sliders',
                        'singular_name' => 'Slider'
                    ),
                    'public'    => true,
                    'supports'  => array( 'title', 'editor', 'thumbnail' ),
                    'hierarchical'  => false,
                    'show_ui'   => true,
                    'show_in_menu'  => false,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export'    => true,
                    'has_archive'   => false,
                    'exclude_from_search'   => false,
                    'publicly_queryable'    => true,
                    'show_in_rest'  => false, //New Gutenberg Editor
                    'menu_icon' => 'dashicons-images-alt2',
                    //'register_meta_box_cb'  =>  array( $this, 'add_meta_boxes' ) Another way to create a metabox for this CPT
                )
            );
        }

        public function add_meta_boxes() {

            add_meta_box(
                'wj_slider_meta_box', // CSS ID for the metabox
                'Link Options', // Title for the metabox
                array( $this, 'add_inner_meta_boxes' ),
                'wj-slider',
                'normal', //context
                'high' //priority
            );
        }

        public function add_inner_meta_boxes( $post ) { //the paramerter '$post' is the POST Object

            require_once( WJ_SLIDER_PATH . 'views/wj-slider_metabox.php' );
        }

        public function save_post( $post_id ) {

            if( isset( $_POST['wj_slider_nonce'] ) ){
                if( ! wp_verify_nonce( $_POST['wj_slider_nonce'], 'wj_slider_nonce' ) ){
                    return;
                }
            }

            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
                return;
            }

            if( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'wj-slider' ){
                if( ! current_user_can( 'edit_page', $post_id ) ){
                    return;
                }elseif( ! current_user_can( 'edit_post', $post_id ) ){
                    return;
                }
            }

            if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ) {
                $old_link_text = get_post_meta( $post_id, 'wj_slider_link_text', true );
                $new_link_text = sanitize_text_field( $_POST['wj_slider_link_text'] );
                $old_link_url = get_post_meta( $post_id, 'wj_slider_link_url', true );;
                $new_link_url = esc_url_raw( $_POST['wj_slider_link_url'] );

                if( empty( $new_link_text ) ) {
                    update_post_meta( $post_id, 'wj_slider_link_text', 'Add some text');
                } else {
                    update_post_meta( $post_id, 'wj_slider_link_text', $new_link_text, $old_link_text );
                }

                if( empty( $new_link_url ) ) {
                    update_post_meta( $post_id, 'wj_slider_link_url', '#' );
                } else {
                    update_post_meta( $post_id, 'wj_slider_link_url', $new_link_url, $old_link_url );
                }
            }
        } 
    }//endClass
}//endif
