<?php
/**
 * PHP functions and definitions
 *
 * Author TechyTrion
 *
 */

function custom_hidden_input_shortcode($atts) {
    $post_id = get_the_ID();
    ob_start(); ?>
    <input type="hidden" id="post_id" name="_id" value="<?php echo esc_attr($post_id); ?>">
    <?php $output = ob_get_clean();
    return $output;
}
add_shortcode('custom_hidden_input', 'custom_hidden_input_shortcode');

