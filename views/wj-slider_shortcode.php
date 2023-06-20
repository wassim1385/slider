<h3><?php echo ! empty( $content ) ? esc_html( $content ) : esc_html( WJ_Slider_Settings::$options['wj_slider_title'] ); ?></h3>
<div class="wj-slider flexslider <?php echo isset( WJ_Slider_Settings::$options['wj_slider_style'] ) ? esc_attr( WJ_Slider_Settings::$options['wj_slider_style'] ) : 'style-1'; ?>">
    <ul class="slides withbackground <?php echo 'opacity-' . esc_html( WJ_Slider_Settings::$options['wj_slider_overlay_opacity'] ); ?>">
        <?php
        $args = array(
            'post_type' => 'wj-slider',
            'post_status' => 'publish',
            'post__in' => $id,
            'orderby' => $orderby
        );
        $query = new WP_Query( $args );
        if( $query->have_posts() ) :
            while( $query->have_posts() ) : $query->the_post();
            $button_text = get_post_meta( get_the_ID(), 'wj_slider_link_text', true );
            $button_url = get_post_meta( get_the_ID(), 'wj_slider_link_url', true );
            ?>
        <li>
            <div class="flex-img">
                <?php if( has_post_thumbnail(  ) ) {
                    the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) );
                } else { ?>
                    <img src="<?php echo WJ_SLIDER_URL . 'assets/images/default.jpg'; ?>" class="img-fluid wp-post-image">
                <?php } ?>
            </di>
            <div class="wjs-container">
                <div class="slider-details-container">
                    <div class="wrapper">
                        <div class="slider-title">
                            <h2><?php the_title(); ?></h2>
                        </div>
                        <div class="slider-description">
                            <div class="subtitle"><?php the_content(); ?></div>
                            <a class="link" href="<?php echo esc_attr( $button_url ) ?>"><?php echo esc_html( $button_text ); ?></a>
                        </div>
                    </div>
                </div>              
            </div>
        </li>
        <?php endwhile;
        wp_reset_postdata();
        endif;
        ?>
    </ul>
</div>