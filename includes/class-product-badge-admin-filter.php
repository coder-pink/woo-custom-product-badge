<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WCPB_Product_Badge_Admin_Filter {

    public function __construct() {
        add_action( 'restrict_manage_posts', [ $this, 'add_badge_filter_dropdown' ] );
        add_action( 'pre_get_posts', [ $this, 'filter_products_by_badge' ] );
    }

    public function add_badge_filter_dropdown( $post_type ) {
        if ( 'product' !== $post_type ) return;

        $current = isset( $_GET['product_badge_filter'] ) ? sanitize_text_field( $_GET['product_badge_filter'] ) : '';

        $badges = [
            '' => __( 'All Badges', 'woo-custom-product-badge' ),
            'Best Seller' => __( 'Best Seller', 'woo-custom-product-badge' ),
            'Hot Deal' => __( 'Hot Deal', 'woo-custom-product-badge' ),
            'New Arrival' => __( 'New Arrival', 'woo-custom-product-badge' ),
        ];

        echo '<select name="product_badge_filter">';
        foreach ( $badges as $value => $label ) {
            printf( '<option value="%s" %s>%s</option>',
                esc_attr( $value ),
                selected( $current, $value, false ),
                esc_html( $label )
            );
        }
        echo '</select>';
    }

    public function filter_products_by_badge( $query ) {
        global $pagenow;

        if ( 'edit.php' !== $pagenow || ! is_admin() || 'product' !== $query->get( 'post_type' ) ) {
            return;
        }

        if ( ! empty( $_GET['product_badge_filter'] ) ) {
            $meta_query = [
                [
                    'key'   => '_wcpb_product_badge',
                    'value' => sanitize_text_field( $_GET['product_badge_filter'] ),
                    'compare' => '='
                ]
            ];
            $query->set( 'meta_query', $meta_query );
        }
    }
}
