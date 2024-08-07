<?php get_header(); ?>
                <div id="content" class="single">
<?php if ( function_exists( 'kama_breadcrumbs' ) ) kama_breadcrumbs( '' ); ?>
<?php if ( get_option( 'business_ads-4' ) != '' ) { ?>
                    <div class="ads-4">
<?php if ( get_option( 'business_ads-4' ) <> '' ) { echo stripslashes ( stripslashes ( get_option( 'business_ads-4' ) ) ); } ?>
                    </div>
<?php } ?>	
<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" class="post">
                        <h1 class="post-title"><?php the_title(); ?></h1>
<!-- all - adaptiv -->
<?php echo wp_get_attachment_image( $attachment_id, 'full' ); ?>
<!-- all - adaptiv -->
                        <div class="gallery">
                            <span>Photo Gallery of the <?php printf( __( ' %2$s ', 'tetapsemangat' ), esc_url( get_permalink( $post->post_parent ) ), get_the_title( $post->post_parent ) ); ?></span>
<?php single_random_images(); ?>
                        </div>
                        <div class="social">
                            Author: Laptopdes

                        </div>
<!-- all - adaptiv -->
                    </div>
<?php comments_template(); ?>
<?php } } else { ?>
                    <h1 class="post-title">Not Found</h1>
                    <p>Sorry, but you are looking for something that isn't here.</p>
<?php } ?>
                </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>