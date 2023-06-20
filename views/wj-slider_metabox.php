<?php
    $link_text = get_post_meta( $post->ID, 'wj_slider_link_text', true );
    $link_url = get_post_meta( $post->ID, 'wj_slider_link_url', true );
?>
<table class="form-table wj-slider-metabox">
<input type="hidden" name="wj_slider_nonce" value="<?php echo wp_create_nonce( "wj_slider_nonce" ); ?>">
    <tr>
        <th>
            <label for="wj_slider_link_text">Link Text</label>
        </th>
        <td>
            <input 
                type="text" 
                name="wj_slider_link_text" 
                id="wj_slider_link_text" 
                class="regular-text link-text"
                value="<?php echo esc_attr( $link_text ); ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="wj_slider_link_url">Link URL</label>
        </th>
        <td>
            <input 
                type="url" 
                name="wj_slider_link_url" 
                id="wj_slider_link_url" 
                class="regular-text link-url"
                value="<?php echo esc_url( $link_url ); ?>"
                required
            >
        </td>
    </tr>               
</table>

