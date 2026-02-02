<div id="ttr_sidebar" class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
    <h2 ><?php _e('Categories'); ?></h2>
    <ul > <?php wp_list_categories(['orderby' => 'name', 'title_li' => '']); ?> </ul>
    <h2 ><?php _e('Archives'); ?></h2>
    <ul > <?php wp_get_archives(); ?> </ul>

    <?php if (class_exists('WooCommerce')) :
        $args = [
            'post_type' => 'product',
            'posts_per_page' => 1,
            'orderby' => 'rand',
            'post_status' => 'publish',
        ];
        $random_product = new WP_Query($args);
        if ($random_product->have_posts()) :
            while ($random_product->have_posts()) : $random_product->the_post();
                global $product;
    ?>
    <div class="store-widget">
        <a href="<?php the_permalink(); ?>" class="store-widget-link">
            <div class="store-widget-image">
                <?php if (has_post_thumbnail()) :
                    the_post_thumbnail('medium');
                else : ?>
                    <div class="no-image">No Image</div>
                <?php endif; ?>
            </div>
            <div class="store-widget-info">
                <h3><?php the_title(); ?></h3>
                <?php if ($product) : ?>
                    <span class="price"><?php echo $product->get_price_html(); ?></span>
                <?php endif; ?>
                <span class="shop-now">Buy Now →</span>
            </div>
        </a>
    </div>
    <?php
            endwhile;
            wp_reset_postdata();
        endif;
    endif;
    ?>
  
</div>
