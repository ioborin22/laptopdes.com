<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
die ( 'Please do not load this page directly. Thanks!' );
if ( post_password_required() ) { 
?>
<p class="nocomments"><?php _e('Password protected.', 'business'); ?></p>
<?php return; } ?>
<div class="comments-box">
<?php if ( have_comments() ) : ?>
<h2><?php comments_number('No Comments', '1 Comment', '% Comments' );?></h2>
<span class="jump-comment"><a href="#respond" class="scroll">Skip to Comment Form &darr;</a></span>
<div class="clear"></div>
<ol class="commentlist">
<?php wp_list_comments('avatar_size=60'); ?>
</ol>
<div class="navigation">
<div class="alignleft"><?php previous_comments_link() ?></div>
<div class="alignright"><?php next_comments_link() ?></div>
</div>
<?php else : ?>
<?php if ('open' == $post->comment_status) : ?>
<?php else : ?>
<?php endif; ?>
<?php endif; ?>
<?php if ('open' == $post->comment_status) : ?>
<div id="respond">
<?php _e('<div class="join">Leave a comment</div>', 'business'); ?>
<div class="cancel-comment-reply"> 
<small><?php cancel_comment_reply_link(); ?></small>
</div>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be', 'business') ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('Logged in', 'business') ?></a> <?php _e('to post comment', 'business') ?>.</p>
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID ) : ?>
<p><?php _e('Logged as', 'business') ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out', 'business') ?> &raquo;</a></p>
<?php else : ?>
<p>
<input type="text" name="author" class="txt" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><?php _e('Name', 'business') ?> <?php if ($req) ?> (<?php _e('Required', 'business'); ?>) <?php ; ?></label>
</p>
<p>
<input type="text" name="email" class="txt" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><?php _e('Mail (will not be published)', 'business') ?> <?php if ($req) ?> (<?php _e('Required', 'business'); ?>) <?php ; ?></label>
</p>
<p>
<input type="text" name="url" class="txt" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><?php _e('Website', 'business') ?></label>
</p>
<?php endif;?>
<p><textarea name="comment" id="comment" tabindex="4"></textarea></p>
<input name="submit" type="submit" id="submit" class="button" tabindex="5" value="<?php _e('Submit Comment', 'business') ?>" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<?php comment_id_fields(); ?>
<?php do_action('comment_form', $post->ID); ?>
</form>
<?php endif; ?>
</div>
<?php endif; ?>
</div>