<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="//www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name=viewport content="width=device-width, initial-scale=1">
        <title><?php wp_title( '' ); ?></title>
<link href="https://laptopdes.com/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
<?php if ( wp_is_mobile() ) { ?>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/mobile.css" />
<?php } ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); } ?>
<?php wp_head(); ?>

    </head>
    <body <?php body_class(); ?>>
<?php include( 'ads-floating.php' ); ?>
        <div id="index">
            <div id="header">
                <div class="left">
                    <a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo"><?php bloginfo( 'name' ); ?></a>
                </div>
<?php if ( get_option( 'business_ads-1' ) != '' ) { ?>
                <div class="right">		
                    <div class="ads-1">
<?php if ( get_option( 'business_ads-1' ) <> '' ) { echo stripslashes ( stripslashes ( get_option( 'business_ads-1' ) ) ); } ?>
                    </div>
                </div>
<?php } ?>
                <ul class="nav">
                    <li><a href="https://laptopdes.com">Home</a></li>			
                    <li><a href="https://laptopdes.com/category/ideas/">Ideas</a></li> 
                    <li><a href="https://laptopdes.com/category/laptop-desk-types/">Types</a></li> 
                    <li><a href="https://laptopdes.com/category/brands/">Brands</a></li> 
                    <li><a href="https://laptopdes.com/category/colors/">Colors</a></li> 
                    <li><a href="https://laptopdes.com/category/sizes/">Sizes</a></li> 
                    <li><a href="https://laptopdes.com/category/tips-ideas/">Tips</a></li> 
                </ul>
                <form action="<?php bloginfo( 'url' ); ?>" method="get" class="search">
                    <input type="text" name="s" value="Search in this site..." onfocus="if (this.value == 'Search in this site...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search in this site...';}" />
                    <input type="submit" value="Search" />
                </form>
            </div>
            <div id="main">

