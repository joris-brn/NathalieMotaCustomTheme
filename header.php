<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF+1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>
</head>
<header>
<div class="logo">
<?php
if (function_exists('the_custom_logo')) {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        echo '<a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';
    }
}
?>
</div>
<nav class="header-menu">
      <?php wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'menu_class' => 'header-menu'
      )); ?>
    <button id="menu_mobile" class="burger_button">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
    </button>
    </nav>
</header>
<div class="fullscreen_menu">
    <?php wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'menu_class' => 'header-mobile'
      )); ?>
</div>
<body>

