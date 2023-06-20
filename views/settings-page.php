<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <?php $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'main_options' ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=wj_slider_admin&tab=main_options" class="nav-tab <?php echo $active_tab == 'main_options' ? 'nav_tab_active' : ''; ?>">Main Options</a>
        <a href="?page=wj_slider_admin&tab=additional_options" class="nav-tab <?php echo $active_tab == 'additional_options' ? 'nav_tab_active' : ''; ?>">Additional options</a>
    </h2>
    <form action="options.php" method="post">
    <?php
        if( $active_tab == 'main_options' ) {
            settings_fields( 'wj_slider_group' );
            do_settings_sections( 'wj_slider_page1' );
        } else {
            settings_fields( 'wj_slider_group' );
            do_settings_sections( 'wj_slider_page2' );
        }
        submit_button( 'Save Settings' );
    ?>
    </form>
</div>