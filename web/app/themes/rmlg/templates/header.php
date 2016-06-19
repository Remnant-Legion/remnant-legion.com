<header class="banner">
    <div class="container">
        <nav class="navbar navbar-defualt navbar-fixed-top visible-xs mobile">
            <a class="brand" href="#home-page">
                <img class="img-responsive logo" alt="<?php bloginfo('name'); ?>" src="<?= get_stylesheet_directory_uri();?>/dist/images/logo.png"/>
                <span class="logo-text"><?php bloginfo('name'); ?></span>
            </a>
            <div class="clearfix"></div>
            <?php
            if (has_nav_menu('primary_navigation')) :
                echo '<div class="cover"></div>';
                wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav navbar-lower']);
            endif;
            ?>
        </nav>

        <nav class="navbar navbar-defualt navbar-fixed-top hidden-xs">
            <a class="brand" href="$home-page">
                <img class="img-responsive logo" alt="<?php bloginfo('name'); ?>" src="<?= get_stylesheet_directory_uri();?>/dist/images/logo.png"/>
                <span class="logo-text"><?php bloginfo('name'); ?></span>
            </a>
            <?php
            if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav navbar-right']);
            endif;
            ?>
        </nav>
    </div>
</header>
