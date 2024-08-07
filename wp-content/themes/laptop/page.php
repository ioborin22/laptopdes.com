<?php get_header(); ?>
<?php 
	global $post;
	$prid = $post->post_parent;
	if ( $prid == '0' ) {

	} 
	else {
		$parr = get_post( $prid );
		$prslug = $parr->post_name;
	}
	if ( $prslug == 'sitemap' ) {
		$srequri = urldecode( $_SERVER['REQUEST_URI'] );	
		$ismap = strpos ( $srequri, 'map-' );
		$isgallery = strpos ( $srequri, 'gallery-' );
		$firstchar = basename( $srequri );
		if ( $ismap ) {
			$firstchar = str_replace ( 'map-', '', $firstchar );
			$whichis = 'Articles';
		} 
		elseif ( $isgallery ) {
			$firstchar = str_replace ('gallery-','',$firstchar);
			$whichis = 'Gallery';
		} 
		else {
			$firstchar = $firstchar;
			$whichis = '';
		}
		$postids = $wpdb->get_col( 
			$wpdb->prepare (
				"SELECT ID
				FROM $wpdb->posts
				WHERE SUBSTR( $wpdb->posts.post_title, 1, 1 ) = %s 
				ORDER BY $wpdb->posts.post_title", $firstchar 
			);
		);
		if ( $postids ) {
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$postperpage = '-1';
			if ( $ismap ) {
				$args = array (
					'post__in' => $postids,
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => $postperpage,
					'paged' => $paged
				);
			} 
			elseif ( $isgallery ) {
				$args = array (
					'post__in' => $postids,
					'post_type' => 'attachment',
					'post_status' => 'inherit',
					'posts_per_page' => $postperpage,
					'paged' => $paged
				);
			} else {
				$args = array();
			}
			$isithere = true;
			query_posts( $args );
		} 
		else {
			$isithere = false;
		}
?>
				<div id="content">
                    <h1>Sitemap <?php echo $whichis.' : '.strtoupper( $firstchar ); ?></h1>
	<?php if ( have_posts() ) { ?>
                    <ul>
		<?php while ( have_posts() ) { the_post(); ?>    
<?php
	if( $isithere ) {
		global $wp_query;
		$parid = $wp_query->post->post_parent;
		$prstatus = get_post_status( $parid );
		if ( $prstatus == 'draft' ) { $isdraft = true; } else { 
			$isdraft = false; 
		}
		if ( $isdraft ) {
		} 
		else {
?>
                        <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
<?php } } else { echo '<p>No '.$whichis.' started with '.ucwords( $firstchar ).' yet. Check back soon.</p>'; } } ?>
                    </ul>
	<?php } else { echo '<p>No '.$whichis.' started with '.ucwords( $firstchar ).' yet. Check back soon.</p>'; } ?>  
                </div>
<?php include ( 'page-sidebar.php' ); ?>
<?php } else { ?>
                <div id="content">
<?php if ( get_option( 'business_ads-4' ) != '' ) { ?>
                    <div class="ads-4">
<?php if ( get_option( 'business_ads-4' ) <> '' ) { echo stripslashes ( stripslashes ( get_option( 'business_ads-4' ) ) ); } ?>
                    </div>
<?php } ?>
<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>
                    <div id="post-<?php the_ID(); ?>" class="post">
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <div class="entry">
<?php the_content(); ?>
                        </div>
                    </div>

<?php } } ?>
                </div>
<?php get_sidebar(); ?>
<?php } ?>
<?php get_footer(); ?>