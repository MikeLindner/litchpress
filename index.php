<?php get_header();

const POST_SIZE = 700;


// Function to get the first image from post content
function get_first_image_from_post($post_content)
{
    $pattern = '/<img.*?src=["\'](.*?)["\']/i';
    preg_match($pattern, $post_content, $matches);

    if (!empty($matches) && isset($matches[1])) {
        return $matches[1]; // Return the URL of the first image
    }

    return false; // No image found
}



// Function to truncate content while preserving HTML tags
function custom_truncate_content($content, $limit)
{
    $allowed_tags = array('a', 'video'); // add more tags as needed
    $content = strip_tags($content, $allowed_tags); // Remove unwanted HTML tags
    $content = substr($content, 0, $limit);
    $content = rtrim($content, " \t\n\r\0\x0B.,;"); // Remove trailing characters to ensure valid HTML

    //  If the content was truncated, add a "Read more" link
    if (strlen($content) >= POST_SIZE) {
        $content .= '... <a href="' . get_permalink() . '"><br>Read more...</a>';
    }
    return apply_filters('the_content', $content);
}

?>
<style>
    #ttr_content a:hover {
        color: white;
    }
</style>
<div id="ttr_main" class="row">
    <div id="ttr_content" class="col-lg-9 col-sm-8 col-md-9 col-12">
        <div class="row">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h1><a href="<?= get_permalink() ?>"><?php the_title(); ?></a></h1>
                        <b><?php the_time('F jS, Y') ?></b>
                        <br><br>
                        <?php
                        $thumbnail_url = get_first_image_from_post(get_the_content());
                        if ($thumbnail_url) :
                        ?>
                            <div class="post-thumbnail">
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            </div>
                        <?php endif; ?>
                        <br>
                        <?php
                        $limited_content = custom_truncate_content(get_the_content(), POST_SIZE); // Change 500 to your desired number of characters
                        echo $limited_content;
                        ?>
                        <br>
                    </div>

                <?php endwhile;
            else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>

<!--
xs (for phones - screens less than 768px wide)
sm (for tablets - screens equal to or greater than 768px wide)
md (for small laptops - screens equal to or greater than 992px wide)
lg (for laptops and desktops - screens equal to or greater than 1200px wide)
-->