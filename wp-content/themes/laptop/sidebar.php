                <div id="sidebar">
<?php if ( get_option( 'business_ads-2' ) != '') { ?>
                    <div class="ads-2">
<?php if ( get_option( 'business_ads-2' ) <> '' ) { echo stripslashes ( stripslashes( get_option( 'business_ads-2' ) ) ); } ?>
                    </div>
<?php } ?>
                    <div class="widget">
                        <span>Recent Post</span>
                        <ul>
<?php $recent_posts = get_posts( 'numberposts=4&orderby=rand' ); foreach( $recent_posts as $post ) { setup_postdata( $post ); ?>
                            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
<?php } ?>
                        </ul>
                    </div>
                    <div class="widget gallery">
                        <span>My Gallery</span>
                        <ul>
<?php $recent_posts = get_posts( 'numberposts=4&orderby=rand' ); foreach( $recent_posts as $post ) { setup_postdata( $post ); ?>
                            <li><?php sidebar_gallery(); ?></li>
<?php } ?>
                        </ul>
                    </div>
                </div>