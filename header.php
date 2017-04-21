<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>?ver=<?php echo time(); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="wrapper" class="hfeed">
        <header id="header" role="banner">
            <section id="branding">
                <div id="site-title">
                    <?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '<h1>'; } ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a><?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '</h1>'; } ?>
                </div>
                <div id="site-tagline">
	                <?php echo get_bloginfo( 'description' ); ?>
                </div>
			</section>
			<div id="menu-search-bar" class="clearfix">
				<div id="mobile-buttons" class="clearfix">
					<div id="menu-button">
	 	              	<i class="fa fa-bars mobile-icon"></i>     
		            </div>
		            <div id="search-button">
			            <i class="fa fa-search mobile-icon"></i>
		            </div>
				</div>

	            <nav id="menu" role="navigation">
	                <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
	            </nav>
	            <div id="search">
					<?php get_search_form(); ?>  
	            </div> 
			</div>         

        </header>

        <div id="container">
