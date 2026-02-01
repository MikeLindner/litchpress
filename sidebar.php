<div id="ttr_sidebar" class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
    <h2 ><?php _e('Categories'); ?></h2>
    <ul > <?php wp_list_categories(['orderby' => 'name', 'title_li' => '']); ?> </ul>
    <h2 ><?php _e('Archives'); ?></h2>
    <ul > <?php wp_get_archives(); ?> </ul>

    <iframe width='160' height='400' src='https://leanpub.com/CloudBook/embed' frameborder='0' allowtransparency='true'></iframe>
  
</div>
