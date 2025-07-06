<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WCPB_Product_Badge_Shortcode {

    public function __construct() {
        add_shortcode( 'custom_badge_products', [ $this, 'render_badge_products' ] );
    }

    public function render_badge_products( $atts ) {
        $atts = shortcode_atts([
            'badge' => '',
        ], $atts, 'custom_badge_products' );

        $query = new WP_Query([
            'post_type' => 'product',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key'   => '_wcpb_product_badge',
                    'value' => sanitize_text_field( $atts['badge'] ),
                    'compare' => '='
                ]
            ]
        ]);

        if ( ! $query->have_posts() ) {
            return '<p>No products found.</p>';
        }

        ob_start();
        echo '<ul class="wcpb-product-list">';
        while ( $query->have_posts() ) {
            $query->the_post();
            global $product;
            echo '<li>';
            echo '<a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a>';
            if ( $product && method_exists( $product, 'get_price_html' ) ) {
                echo '<div>' . $product->get_price_html() . '</div>';
            }
            echo '</li>';
        }
        echo '</ul>';

        wp_reset_postdata();

        return ob_get_clean();
    }
}
