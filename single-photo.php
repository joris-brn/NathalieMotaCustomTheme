<?php get_header(); ?>

<?php
while ( have_posts() ) :
	the_post();
?>
<div class="body">
    <div class="conteneur">
        <div class="information-photo">
            <ul>
            <li>
                <h2 class="titre-photo"> <?php echo the_title(); ?></h2>
            </li>
            <li>
                <p class="info">RÉFÉRENCE : <span id="reference"> <?php echo get_field('reference'); ?></span>
                </p>
            </li>
             <li>
                <p class="info">CATÉGORIE : <?php echo get_the_terms(get_the_ID(), 'categorie')[0]->name; ?></p>
            </li> 
            <li>
                <p class="info">FORMAT : <?php echo get_the_terms(get_the_ID(), 'format') [0]->name; ?></p>
            </li>
            <li>
                <p class="info">TYPE : <?php echo get_field('Type'); ?></p>
            </li>
            <li>
                <p class="info">ANNÉE : <?php echo get_the_terms(get_the_ID(), 'annee') [0]->name; ?></p>
            </li>
        </div>
        <div class='affichage-photo'>
            <?php the_post_thumbnail ("medium_large"); ?>
        </div>
    </ul>
    </div>
<div class="contact_block">
    <div class="contact">
        <p>Cette photo vous intéresse ?</p>
        <button class="contact_button">Contact</button> 
    </div>
    <div class="nav_photo">        
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();

    if ($next_post || $previous_post) {
        the_post_navigation(
            array(
                'next_text' => $next_post ? '<div class="next-post-arrow"><div class="custom_arrow"><b>&#10230;</b></div><div class="miniaturenext">' . get_the_post_thumbnail($next_post->ID, [100,100]) . '</div></div>' : '',
                'prev_text' => $previous_post ? '<div class="prev-post-arrow"><div class="custom_arrow"><b>&#10229;</b></div><div class="miniatureprev">' . get_the_post_thumbnail($previous_post->ID, [100,100]) . '</div></div>' : '',
            )
        );
    }
    ?>  
    </div>
</div>
<section class="recommandations">
    <div class="title_reco">
        <h3>Vous aimerez aussi</h3>
    </div>
    <div class="conteneur_photo_reco">
    <?php

// On récupère la catégorie de la photo affichée

$categories = get_the_terms(get_the_ID(), 'categorie');
if ($categories && !is_wp_error($categories)) {
    $category_ids = array();
    foreach ($categories as $category) {
        $category_ids[] = $category->term_id;
    }

    // On exclut la photo actuelle de la requête
    $args = array(
        'post_type' => 'photo', 
        'posts_per_page' => 2, 
        'post__not_in' => array(get_the_ID()), 
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'id',
                'terms' => $category_ids,
            ),
        ),
    );

    $related_photos_query = new WP_Query($args);

    // Affichage des photos 

    if ($related_photos_query->have_posts()) {
        echo '<div class="related-photos">';
        while ($related_photos_query->have_posts()) {
            $related_photos_query->the_post();
            ?>
            <div class="related-photo">
             <?php get_template_part( 'template_part/photo_block', "image"); ?>
            </div>
            <?php
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        // Si aucune photo n'est disponible, ne pas afficher la section
        ?>
        <style>.recommandations { display: none; }</style>
        <?php
    }
}
?>

    </div>
</section>


<?php
endwhile;
?>
</div>
<?php get_footer(); ?>