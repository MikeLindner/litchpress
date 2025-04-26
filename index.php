<?php get_header(); ?>
<div id="ttr_main" class="row">
<div id="ttr_content" class="col-lg-12 col-sm-12 col-md-8 col-xs-12">
    <div class="row">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h1><?php the_title(); ?></h1>
            <b><?php the_time('F jS, Y') ?></b>
            <p><?php the_content(__('(more...)')); ?></p>
        </div>

        <?php endwhile; else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php //get_sidebar(); ?>
</div>

This is a Test Message

<?php get_footer(); ?>

<!--
xs (for phones - screens less than 768px wide)
sm (for tablets - screens equal to or greater than 768px wide)
md (for small laptops - screens equal to or greater than 992px wide)
lg (for laptops and desktops - screens equal to or greater than 1200px wide)
-->

