<?php get_header(); ?>
				<div id="content">
<?php if ( is_front_page() ) { ?>
                    <h1 class="single-title">Laptop Desks 2015</h1>
<?php } ?>
<?php if ( get_option( 'business_ads-4' ) != '' ) { ?>
                    <div class="ads-4">
<?php if ( get_option( 'business_ads-4' ) <> '' ) { echo stripslashes(stripslashes(get_option( 'business_ads-4' ) ) ); } ?>
                    </div>
<?php } ?>
<?php if ( have_posts() ) { $count = 1; while ( have_posts() ) { the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" class="post one">
                        <?php random_images(); ?>
                        <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        <div class="entry">

						    <p><?php kama_excerpt( 'maxchar=380' ); ?></p>
                        </div>
                    </div>
<?php if ( $count == 2 ) { include( 'ads.php' ); } $count = $count + 1; ?>
<?php } } else { ?>
                    <h1 class="post-title">Not Found</h1>
                    <p>Sorry, but you are looking for something that isn't here.</p>
<?php } ?>
<?php kama_pagenavi(); ?>
                </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>