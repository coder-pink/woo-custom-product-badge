<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WCPB_Product_Badge_Display {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        add_action( 'woocommerce_single_product_summary', [ $this, 'display_badge' ], 4 ); // Before the title
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            'wcpb-styles',
            plugins_url( '../assets/css/custom-badge.css', __FILE__ ),
            [],
            '1.0'
        );
    }



    public function display_badge() {
    global $post;
    $badge = get_post_meta( $post->ID, '_wcpb_product_badge', true );

    if ( ! empty( $badge ) ) {
        
        $badge_class = sanitize_html_class( strtolower( str_replace( ' ', '-', $badge ) ) );

        echo '<div class="wcpb-badge ' . esc_attr( $badge_class ) . '">' . esc_html( $badge ) . '</div>';
    }
}

}
