<?php get_header() ?>
    <div class="hero-header">
        <img src="<?php echo  get_stylesheet_directory_uri() . '/assets/images/heroheader.png'; ?> " alt="Hero header du site de Nathalie Mota">
    </div>
    <section class="affichage_photo-fp">
    <?php
$affichagefront = new WP_Query(array(
    'post_type' => 'photo', 
    'posts_per_page' => -1,
));

if ($affichagefront->have_posts()) { 
    while ($affichagefront->have_posts()) { 
        $affichagefront->the_post(); 
        get_template_part('/template_part/photo_block'); 
    }
}

?>
</section>
<?php get_footer() ?>