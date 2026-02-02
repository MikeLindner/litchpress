<?php
/**
 * WooCommerce Template
 * 
 * This template is used for all WooCommerce pages (shop, product, cart, checkout, etc.)
 * It displays content full-width without the sidebar.
 *
 * @package litchpress
 */

get_header(); ?>

<div id="ttr_main" class="row">
    <div id="ttr_content" class="col-12">
        <?php woocommerce_content(); ?>
    </div>
</div>

<?php get_footer(); ?>
