<?php 

/**
 * Plugin Name: EIC OJ
 * Description: A plugin to display a custom stacked gallery for WooCommerce products.
 * Version: 1.0
 * Author: Elegance In Code
 * Author URI: https://eleganceincode.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function custom_add_stacked_product_gallery() {
    global $product;

    if ( ! $product ) {
        return;
    }

    $attachment_ids = $product->get_gallery_image_ids();

    if ( $attachment_ids || $product->get_image_id() ) {
        echo '<div class="eic_custom-product-gallery woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images">';
        echo '<div class="eic_custom-product-image">' . wp_get_attachment_image( $product->get_image_id(), 'medium' ) . '</div>';

        foreach ( $attachment_ids as $attachment_id ) {
            echo '<div class="eic_custom-product-image">' . wp_get_attachment_image( $attachment_id, 'medium' ) . '</div>';
        }

        echo '</div>';
    }
}

// add_action('woocommerce_before_single_product_summary', 'custom_add_stacked_product_gallery', 20);

function eic_oj_stacked_gallery_shortcode( $atts ) {
    ob_start();

    global $product;

    if ( ! $product ) {
        return '<p>No product found.</p>';
    }

    custom_add_stacked_product_gallery();

    return ob_get_clean();
}
add_shortcode( 'eic_stacked_product_gallery', 'eic_oj_stacked_gallery_shortcode' );


function eic_oj_custom_css() {
    ?>
    <style>
        .eic_custom-product-gallery {
            display: flex;
            flex-direction: column;
			justify-content: center;
			width: 100%!important;
        }

        .eic_custom-product-image {
            margin-bottom: 15px;
        }

		.eic_custom-product-image img{
			width: 100%;
		}
    </style>
    <?php
}
add_action('wp_head', 'eic_oj_custom_css');