<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WCPB_Product_Badge_Meta_Box {

    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add_badge_meta_box' ] );
        add_action( 'save_post_product', [ $this, 'save_badge_meta' ] );
    }

    public function add_badge_meta_box() {
        add_meta_box(
            'wcpb_badge_meta_box',
            __( 'Product Badge', 'woo-custom-product-badge' ),
            [ $this, 'render_meta_box_content' ],
            'product',
            'side',
            'default'
        );
    }

    public function render_meta_box_content( $post ) {
        wp_nonce_field( 'wcpb_save_badge_meta', 'wcpb_badge_meta_nonce' );
        $selected = get_post_meta( $post->ID, '_wcpb_product_badge', true );

        $options = [
            '' => __( 'None', 'woo-custom-product-badge' ),
            'Best Seller' => __( 'Best Seller', 'woo-custom-product-badge' ),
            'Hot Deal' => __( 'Hot Deal', 'woo-custom-product-badge' ),
            'New Arrival' => __( 'New Arrival', 'woo-custom-product-badge' ),
        ];

        echo '<select name="wcpb_product_badge" style="width:100%;">';
        foreach ( $options as $value => $label ) {
            printf( '<option value="%s" %s>%s</option>',
                esc_attr( $value ),
                selected( $selected, $value, false ),
                esc_html( $label )
            );
        }
        echo '</select>';
    }

    public function save_badge_meta( $post_id ) {
        if ( ! isset( $_POST['wcpb_badge_meta_nonce'] ) ||
             ! wp_verify_nonce( $_POST['wcpb_badge_meta_nonce'], 'wcpb_save_badge_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if ( isset( $_POST['wcpb_product_badge'] ) ) {
            $badge = sanitize_text_field( $_POST['wcpb_product_badge'] );
            update_post_meta( $post_id, '_wcpb_product_badge', $badge );
        }
    }
}
