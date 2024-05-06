<?php get_header() ?>
<div class="hero-header">
    <img src="<?php echo get_random_photo_url(); ?>" alt="Hero header du site de Nathalie Mota" class="hero-image">
    <div class="hero-overlay">
        <h2>Photographe Event</h2>
    </div>
</div>
    <section class="affichage_photo-fp">
    <?php
$affichagefront = new WP_Query(array(
    'post_type' => 'photo', 
    'posts_per_page' => 8,
    'paged' => 1,
));

if ($affichagefront->have_posts()) { 
    while ($affichagefront->have_posts()) { 
        $affichagefront->the_post(); 
        get_template_part('/template_part/photo_block'); 
    }
}   
?>
</section>
<div class="button_area">
    <button id="load-more-photos">Charger plus</button>
</div>
<?php get_footer() ?>