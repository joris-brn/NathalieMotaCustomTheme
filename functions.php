<?php

/* Ajout des fonctions au thème custom */

function mota_custom_support () {
add_theme_support('title-tag');
add_theme_support('custom-logo', array() );
add_theme_support('post-thumbnails');
}

/* Ajout des différents assets */

function mota_custom_assets () {
    wp_enqueue_style ('main_style', get_stylesheet_directory_uri() . './assets/css/main.css');
    wp_enqueue_script ('custom_script', get_template_directory_uri() . './assets/script.js');
    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), null, false);
}

/* Installation des polices */

function mota_custom_fonts() {
   wp_enqueue_style('space-font', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), false, 'all');  
    wp_enqueue_style('poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), false, 'all');   
}

/* Ajout de l'emplacement de menu du header */

function register_my_menu() {
    register_nav_menu( 'header-menu', __( 'Header', 'text-domain' ) );
    register_nav_menu( 'footer-menu', __( 'Footer', 'text-domain' ) );
}

/* Chargement aléatoire photo Hero-header */

function get_random_photo_url() {
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 1,
        'orderby' => 'rand',
    );

    $random_photo = new WP_Query($args);

    if ($random_photo->have_posts()) {
        $random_photo->the_post();
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
        wp_reset_postdata(); 

        return $image_url;
    }

    return ''; 
}




/* ------------ Requête Ajax pour charger plus de photos---------------- */


/* Chargement du script JS pour Ajax */

function enqueue_load_more_script() {
    if (is_front_page()) {
        wp_enqueue_script(
            'load-more',
            get_stylesheet_directory_uri() . '/assets/load-more.js',
            array('jquery'),
            null,
            true
        );

        wp_localize_script('load-more', 'ajax_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
        ));
    }
}

add_action('wp_enqueue_scripts', 'enqueue_load_more_script');



/* Chargement AJAX pour filtres front-page */
function load_photos() {
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $category = isset($_GET['category']) ? intval($_GET['category']) : '';
    $format = isset($_GET['format']) ? intval($_GET['format']) : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
    );

    // Applique le filtre par catégorie 
    if ($category) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'term_id',
                'terms' => $category,
            ),
        );
    }

    // Applique le filtre par format 
    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'term_id',
            'terms' => $format,
        );
    }

    // Appliquer le tri par date
    if ($sort === 'date_asc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } else {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }

    $query = new WP_Query($args);
    $html = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ob_start();
            get_template_part('/template_part/photo_block');
            $html .= ob_get_clean();
        }
    } else {
        $html = "Aucune photo trouvée.";
    }

    // Vérifie s'il y a encore des pages à charger
    $has_more = $query->max_num_pages > $page;

    wp_reset_postdata();

    echo json_encode(array('html' => $html, 'has_more' => $has_more)); // Inclure 'has_more'
    wp_die();
}





/* ADD ACTION */

add_action('after_setup_theme', 'mota_custom_support');
add_action('wp_enqueue_scripts', 'mota_custom_assets');
add_action('wp_enqueue_scripts', 'mota_custom_fonts');
add_action( 'after_setup_theme', 'register_my_menu' );
add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');


