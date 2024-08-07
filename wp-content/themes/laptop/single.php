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

<?php if ( $images = get_children(array(
		'post_parent' => get_the_ID(),
		'post_type' => 'attachment',
		'numberposts' => 1,
		'post_mime_type' => 'image',
		'orderby' => 'rand',
	))) : ?>
		<?php foreach( $images as $image ) :  ?>
			<?php echo wp_get_attachment_link($image->ID,$post->ID, 'large'); ?>
		<?php endforeach; ?>
	
<?php else: // No images ?>
	<!-- This post has no attached images -->
<?php endif; ?>

<!-- all - adaptiv -->

<?php
	$content = apply_filters( 'the_content', $post->post_content );
	$save = explode( '</p>', $content );
	$tcount = 0;
	$adon = 0;
	foreach( $save as $item ) {
		echo $item;
		echo "</p>";
		if ( preg_match( '/<p> /', $item ) == 0 && $tcount >= 1 && $adon == 0 ) {
			$adon = 1;
?>
<?php if ( $images = get_children(array(
		'post_parent' => get_the_ID(),
		'post_type' => 'attachment',
		'numberposts' => 1,
		'post_mime_type' => 'image',
		'orderby' => 'rand',
	))) : ?>
		<?php foreach( $images as $image ) :  ?>
			<?php echo wp_get_attachment_link($image->ID,$post->ID, 'large'); ?>
		<?php endforeach; ?>
	
<?php else: // No images ?>
	<!-- This post has no attached images -->
<?php endif; ?>	

<?php } if ( preg_match( '/<p> /', $item ) == 0 && $tcount >= 4 && $adon == 1 ) { $adon = 2; ?>
<?php if ( $images = get_children(array(
		'post_parent' => get_the_ID(),
		'post_type' => 'attachment',
		'numberposts' => 1,
		'post_mime_type' => 'image',
		'orderby' => 'rand',
	))) : ?>
		<?php foreach( $images as $image ) :  ?>
			<?php echo wp_get_attachment_link($image->ID,$post->ID, 'large'); ?>
		<?php endforeach; ?>
	
<?php else: // No images ?>
	<!-- This post has no attached images -->
<?php endif; ?>

<?php } $tcount++; } ?>
						
<!-- all - adaptiv -->

                        <div class="gallery">
<?php 
	global $post;
	$attachments = get_children( array( 'post_parent' => get_the_ID(), 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );
	$count = count( $attachments );
	$specific = array();
	$i = 1;
	foreach ( $attachments as $attachment ) {
		$specific[$attachment->ID] = $i;
		++$i;
	}
?> 
                            <span><?php echo "{$specific[$post->ID]} {$count}"; ?> Photos of the <?php the_title(); ?></span>
<?php single_gallery(); ?>
                        </div> 
                        <div class="social">
                            Author: Laptopdes
                        </div>
                    </div>
<?php comments_template(); ?>
<?php } } else { ?>
                    <h1 class="post-title">Not Found</h1>
                    <p>Sorry, but you are looking for something that isn't here.</p>
<?php }  ?>
                    <div class="navigation">
                        <div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
                        <div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
                    </div>
                </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>