<?php

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' ); 

require get_template_directory() . '/options.php';

if ( !function_exists( 'optionsframework_init' ) ) {

	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/' );
	require_once dirname( __FILE__ ) . '/admin/options-framework.php';

}

function nofollow_archives( $link_html ) {

    return str_replace('<a href=', '<a rel="nofollow" href=',  $link_html);

}

function my_archives_widget() { ?>

    <li class="widget">
        <h3>My Archives</h3>
        <div class="widget widget_text">
            <ul>
<?php add_filter('get_archives_link', 'nofollow_archives'); get_archives('postbypost', '3', 'html', '<li class="page_item">','</li>', FALSE); remove_filter('get_archives_link', 'nofollow_archives'); ?>
            </ul>
        </div>
    </li>

<?php
}
add_action( 'widgets_init', 'my_archives_widget_init' );

function my_archives_widget_init() {

	wp_register_sidebar_widget('my_widget_id', 'My Widget', 'my_widget_function');

}

add_theme_support('custom-background');


if ( function_exists( 'register_sidebar' ) ) register_sidebars(1); 

add_action( 'admin_menu', 'business_theme_page' );

function business_theme_page () {
	if ( count( $_POST ) > 0 && isset( $_POST['business_settings'] ) ) {
		$options = array ( 'ads-1', 'ads-2', 'ads-3', 'ads-4', 'ads-6', 'ads-5', 'header', 'analytics' );
		foreach ( $options as $opt ) {
			delete_option ( 'business_'.$opt, $_POST[$opt] );
			add_option ( 'business_'.$opt, $_POST[$opt] );	
		} 
	}
	add_theme_page( __( 'Theme Options' ), __( 'Theme Options' ), 'edit_themes', basename(__FILE__), 'business_settings' );	
}

function business_settings() { ?>

<div class="wrap">
<h3>Advertisemen Options</h3>
<form method="post" action="">
<table class="form-table">
<tr valign="top">
<th scope="row"><label for="ads-1">468x60 Header</label></th>
<td>
<textarea cols="60" rows="5" name="ads-1" id="ads-1" /><?php echo stripslashes(get_option('business_ads-1')); ?></textarea>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="ads-2">160x600 Sidebar</label></th>
<td>
<textarea cols="60" rows="5" name="ads-2" id="ads-2" /><?php echo stripslashes(get_option('business_ads-2')); ?></textarea>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="ads-3">728x90 after Title Att</label></th>
<td>
<textarea cols="60" rows="5" name="ads-3" id="ads-3" /><?php echo stripslashes(get_option('business_ads-3')); ?></textarea>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="ads-4">468x60 Above title of first post</label></th>
<td>
<textarea cols="60" rows="5" name="ads-4" id="ads-4" /><?php echo stripslashes(get_option('business_ads-4')); ?></textarea>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="ads-6">468x60 After 2 Post in Homepage</label></th>
<td>
<textarea cols="60" rows="6" name="ads-6" id="ads-6" /><?php echo stripslashes(get_option('business_ads-6')); ?></textarea>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="ads-5">Floating Ads</label></th>
<td>
<textarea cols="60" rows="5" name="ads-5" id="ads-5" /><?php echo stripslashes(get_option('business_ads-5')); ?></textarea>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="header">Header Scripts</label></th>
<td>
<textarea cols="60" rows="5" name="header" id="header" /><?php echo stripslashes(get_option('business_header')); ?></textarea>
<br /><em>If you need to add scripts to your header (like meta tag verification, perhaps), <br />you should enter them in the box below. They will be added before &lt;/head&gt; tag</em>
</td>
</tr>
<tr>
<th><label for="ads">Google Analytics code:</label></th>
<td>
<textarea name="analytics" id="analytics" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('business_analytics')); ?></textarea>
</td>
</tr>
</table>
<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
<input type="hidden" name="business_settings" value="save" style="display:none;" />
</p>
</form>
</div>

<?php } 

function kama_excerpt( $args = '' ){
	global $post;
	
	$default = array( 'maxchar' => 350, 'text' => '', 'save_format' => false, 'more_text' => 'Читать дальше...', 'echo' => true, );
	
	parse_str( $args, $_args );
	$args = array_merge( $default, $_args );
	extract( $args );
		
	if( ! $text ){
		$text = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
		
		$text = preg_replace ("~\[/?.*?\]~", '', $text ); // убираем шоткоды, например:[singlepic id=3]
		
		// для тега <!--more-->
		if( ! $post->post_excerpt && strpos( $post->post_content, '<!--more-->') ){
			preg_match ('~(.*)<!--more-->~s', $text, $match );
			$text = trim( $match[1] );
			$text = str_replace("\r", '', $text );
			$text = preg_replace( "~\n\n+~s", "</p><p>", $text );
			$text = '<p>'. str_replace( "\n", '<br />', $text ) .' <a href="'. get_permalink( $post->ID ) .'#more-'. $post->ID .'">'. $more_text .'</a></p>';
			
			if( $echo ) return print $text;
			
			return $text;
		}
		elseif( ! $post->post_excerpt )
			$text = strip_tags( $text, $save_format );
	}	
	
	// Обрезаем
	if ( mb_strlen( $text ) > $maxchar ){
		$text = mb_substr( $text, 0, $maxchar );
		$text = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ...', $text ); // убираем последнее слово, оно 99% неполное
	}
	
	// Сохраняем переносы строк. Упрощенный аналог wpautop()
	if( $save_format ){
		$text = str_replace("\r", '', $text );
		$text = preg_replace("~\n\n+~", "</p><p>", $text );
		$text = "<p>". str_replace ("\n", "<br />", trim( $text ) ) ."</p>";
	}
	
	//$out = preg_replace('@\*[a-z0-9-_]{0,15}\*@', '', $out); // удалить *some_name-1* - фильтр сммайлов
	
	if( $echo ) return print $text;
	
	return $text;
}

function kama_breadcrumbs( $sep = 0, $l10n = array(), $args = array() ){
	global $post, $wp_query, $wp_post_types;

	// Локализация
	$default_l10n = array(
		'home'       => 'Home',
		'paged'      => 'Page %s',
		'_404'       => 'Error 404',
		'search'     => 'Search Results for: <b>%s</b>',
		'author'     => 'Author archives: <b>%s</b>',
		'year'       => 'Archive for <b>%s</b> год',
		'month'      => 'Archive for: <b>%s</b>',
		'day'        => '',
		'attachment' => 'Media: %s',
		'tag'        => 'Entries by Tag: <b>%s</b>',
		'tax_tag'    => '%s from "%s" by tag: <b>%s</b>',
	);
	
	// Параметры по умолчанию
	$default_args = array(
		'on_front_page'   => true, // выводить крошки на главной странице
		'show_post_title' => true, // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
		'sep'             => ' » ', // разделитель
	);
	
	// Фильтрует аргументы по умолчанию.
	$default_args = apply_filters('kama_breadcrumbs_default_args', $default_args );
	
	$loc  = (object) array_merge( $default_l10n, $l10n );
	$args = (object) array_merge( $default_args, $args );

	if( $sep === 0 ) $sep = $args->sep;

	$w1 = "                    <div class=\"breadcrumbs\" prefix=\"v: http://rdf.data-vocabulary.org/#\">\n";
	$w2 = "                    </div>\n";
	$patt1 = "                        <span typeof=\"v:Breadcrumb\"><a href=\"%s\" rel=\"v:url\" property=\"v:title\">";
	$sep .= "</span>\n"; // закрываем span после разделителя!
	$linkpatt = $patt1.'%s</a>';
	
	
	// Вывод
	$pg_end = '';
	if ( $paged = $wp_query->query_vars['paged'] ) {
		$pg_patt = $patt1;
		$pg_end = '</a>'. $sep . sprintf( $loc->paged, $paged );
	}

	$out = '';
	if( is_front_page() ){
		return $args->on_front_page ? ( print $w1 .( $paged ? sprintf( $pg_patt, get_bloginfo('url') ) : '' ) . $loc->home . $pg_end . $w2 ) : '';
	}
	elseif( is_404() ){
		$out = $loc->_404; 
	}
	elseif( is_search() ){
		$out = sprintf( $loc->search, strip_tags( $GLOBALS['s'] ) );
	}
	elseif( is_author() ){
		$q_obj = &$wp_query->queried_object;
		$out = ( $paged ? sprintf( $pg_patt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) ):'') . sprintf( $loc->author, $q_obj->display_name ) . $pg_end;
	}
	elseif( is_year() || is_month() || is_day() ){
		$y_url  = get_year_link( $year=get_the_time('Y') );
		$m_url  = get_month_link( $year, get_the_time('m') );
		$y_link = sprintf( $linkpatt, $y_url, $year);
		$m_link = sprintf( $linkpatt, $m_url, get_the_time('F'));
		if( is_year() )
			$out = ( $paged?sprintf( $pg_patt, $y_url):'') . sprintf( $loc->year, $year ) . $pg_end;
		elseif( is_month() )
			$out = $y_link . $sep . ( $paged ? sprintf( $pg_patt, $m_url ) : '') . sprintf( $loc->month, get_the_time('F') ) . $pg_end;
		elseif( is_day() )
			$out = $y_link . $sep . $m_link . $sep . get_the_time('l');
	}

	// Страницы и древовидные типы записей
	elseif( $wp_post_types[ $post->post_type ]->hierarchical ){
		$parent = $post->post_parent;
		$crumbs = array();
		while( $parent ){
			$page = & get_post( $parent );
			$crumbs[] = sprintf( $linkpatt, get_permalink( $page->ID ), $page->post_title );
			$parent = $page->post_parent;
		}
		$crumbs = array_reverse( $crumbs );
		
		foreach( $crumbs as $crumb ) $out .= $crumb . $sep;
		
		$out = $out . ( $args->show_post_title ? $post->post_title : '');
	}
	// Таксономии, вложения и не древовидные типы записей
	else
	{
		// Определяем термины
		if( is_singular() ){
			if( ! $taxonomies ){
				$taxonomies = get_taxonomies( array('hierarchical' => true, 'public' => true) );
				if( count( $taxonomies ) == 1 ) $taxonomies = 'category';
			}
			if( $term = get_the_terms( $post->post_parent ? $post->post_parent : $post->ID, $taxonomies ) ){
				$term = array_shift( $term );
			}
		}
		else
			$term = $wp_query->get_queried_object();
		

		//if( ! $term && ! is_attachment() ) return print "Error: Taxonomy is not defined!"; 
		
		if( $term ){
			$term = apply_filters('kama_breadcrumbs_term', $term );
			
			$pg_term_start = ( $paged && $term->term_id ) ? sprintf( $pg_patt, get_term_link( (int) $term->term_id, $term->taxonomy ) ) : '';

			if( is_attachment() ){
				if( ! $post->post_parent )
					$out = sprintf( $loc->attachment, $post->post_title );
				else
					$out = __crumbs_tax( $term->term_id, $term->taxonomy, $sep, $linkpatt ) . sprintf( $linkpatt, get_permalink( $post->post_parent ), get_the_title( $post->post_parent ) ) . $sep . ( $args->show_post_title ? $post->post_title : '');
			}
			elseif( is_single() ){
				$out = __crumbs_tax( $term->parent, $term->taxonomy, $sep, $linkpatt ) . sprintf( $linkpatt, get_term_link( (int) $term->term_id, $term->taxonomy ), $term->name ). $sep . ( $args->show_post_title ? $post->post_title : '')."\n";
			// Метки, архивная страница типа записи, произвольные одноуровневые таксономии
			}
			elseif( ! is_taxonomy_hierarchical( $term->taxonomy ) ){
				// метка
				if( is_tag() )
					$out = $pg_term_start . sprintf( $loc->tag, $term->name ) . $pg_end;
				// таксономия
				elseif( is_tax() ){
					$post_label = $wp_post_types[ $post->post_type ]->labels->name;
					$tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
					$out = $pg_term_start . sprintf( $loc->tax_tag, $post_label, $tax_label, $term->name ) .  $pg_end;
				}
			}
			// Рубрики и таксономии
			else
				$out = __crumbs_tax( $term->parent, $term->taxonomy, $sep, $linkpatt ) . $pg_term_start . $term->name . $pg_end;
		}
	}

	// замена ссылки на архивную страницу для типа записи 
	$home_after = apply_filters('kama_breadcrumbs_home_after', false, $linkpatt, $sep );

	// ссылка на архивную страницу произвольно типа поста. Ссылку можно заменить с помощью хука 'kama_breadcrumbs_home_after'
	if( ! $home_after && isset( $post->post_type ) && ! in_array( $post->post_type, array('post','page','attachment') ) ){
		$pt_name = $wp_post_types[ $post->post_type ]->labels->name;
		$pt_url  = get_post_type_archive_link( $post->post_type );
		$home_after = ( is_post_type_archive() && ! $paged ) ? $pt_name : ( sprintf( $linkpatt, $pt_url, $pt_name ). ($pg_end?$pg_end:$sep) );
	}

	
	$home = sprintf( $linkpatt, home_url(), $loc->home ). $sep . $home_after;
	
	$out = $w1. $home . $out .$w2;

	return print apply_filters('kama_breadcrumbs', $out, $sep );
}
function __crumbs_tax( $term_id, $tax, $sep, $linkpatt ){
	$termlink = array();
	while( (int) $term_id ){
		$term2      = get_term( $term_id, $tax );
		$termlink[] = sprintf( $linkpatt, get_term_link( (int) $term2->term_id, $term2->taxonomy ), $term2->name ). $sep;
		$term_id    = (int) $term2->parent;
	}
	
	$termlinks = array_reverse( $termlink );
	
	return implode('', $termlinks );
}

function kama_pagenavi( $before = '', $after = '', $echo = true, $args = array() ) {
	// параметры по умолчанию
	$default_args = array(
		'text_num_page'   => '', // Текст перед пагинацией. {current} - текущая; {last} - последняя (пр. 'Страница {current} из {last}' получим: "Страница 4 из 60" )
		'num_pages'       => 10, // сколько ссылок показывать
		'step_link'       => 10, // ссылки с шагом (значение - число, размер шага (пр. 1,2,3...10,20,30). Ставим 0, если такие ссылки не нужны.
		'dotright_text'   => '…', // промежуточный текст "до".
		'dotright_text2'  => '…', // промежуточный текст "после".
		'back_text'       => '« back', // текст "перейти на предыдущую страницу". Ставим 0, если эта ссылка не нужна.
		'next_text'       => 'next »', // текст "перейти на следующую страницу". Ставим 0, если эта ссылка не нужна.
		'first_page_text' => '« to top', // текст "к первой странице". Ставим 0, если вместо текста нужно показать номер страницы.
		'last_page_text'  => 'to end »', // текст "к последней странице". Ставим 0, если вместо текста нужно показать номер страницы.
	);
	
	$args = array_merge( $default_args, $args );
	
	extract( $args );

	global $wp_query;

	$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
	$paged          = (int) $wp_query->query_vars['paged'];
	$max_page       = $wp_query->max_num_pages;

	//проверка на надобность в навигации
	if( $max_page <= 1 )
		return false; 

	if( empty( $paged ) || $paged == 0 ) 
		$paged = 1;

	$pages_to_show = intval( $num_pages );
	$pages_to_show_minus_1 = $pages_to_show-1;

	$half_page_start = floor( $pages_to_show_minus_1/2 ); //сколько ссылок до текущей страницы
	$half_page_end = ceil( $pages_to_show_minus_1/2 ); //сколько ссылок после текущей страницы

	$start_page = $paged - $half_page_start; //первая страница
	$end_page = $paged + $half_page_end; //последняя страница (условно)

	if( $start_page <= 0 ) 
		$start_page = 1;
	if( ($end_page - $start_page) != $pages_to_show_minus_1 ) 
		$end_page = $start_page + $pages_to_show_minus_1;
	if( $end_page > $max_page ) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = (int) $max_page;
	}

	if( $start_page <= 0 ) 
		$start_page = 1;

	//выводим навигацию
	$out = '';

	// создаем базу чтобы вызвать get_pagenum_link один раз
	$link_base = get_pagenum_link( 99999999 ); // 99999999 будет заменено
	$link_base = str_replace( 99999999, '___', $link_base);
	$first_url = user_trailingslashit( get_pagenum_link( 1 ) );
	$out .= $before . "<div class='wp-pagenavi'>\n";

		if( $text_num_page ){
			$text_num_page = preg_replace( '!{current}|{last}!', '%s', $text_num_page );
			$out.= sprintf( "<span class='pages'>$text_num_page</span> ", $paged, $max_page );
		}
		// назад
		if ( $back_text && $paged != 1 ) 
			$out .= '<a class="prev" href="'. str_replace( '___', ($paged-1), $link_base ) .'">'. $back_text .'</a> ';
		// в начало
		if ( $start_page >= 2 && $pages_to_show < $max_page ) {
			$out.= '<a class="first" href="'. $first_url .'">'. ( $first_page_text ? $first_page_text : 1 ) .'</a> ';
			if( $dotright_text && $start_page != 2 ) $out .= '<span class="extend">'. $dotright_text .'</span> ';
		}
		// пагинация
		for( $i = $start_page; $i <= $end_page; $i++ ) {
			if( $i == $paged )
				$out .= '<span class="current">'.$i.'</span> ';
			elseif( $i == 1 )
				$out .= '<a href="'. $first_url .'">1</a> ';
			else
				$out .= '<a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a> ';
		}

		//ссылки с шагом
		$dd = 0;
		if ( $step_link && $end_page < $max_page ){
			for( $i = $end_page+1; $i<=$max_page; $i++ ) {
				if( $i % $step_link == 0 && $i !== $num_pages ) {
					if ( ++$dd == 1 ) 
						$out.= '<span class="extend">'. $dotright_text2 .'</span> ';
					$out.= '<a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a> ';
				}
			}
		}
		// в конец
		if ( $end_page < $max_page ) {
			if( $dotright_text && $end_page != ($max_page-1) ) 
				$out.= '<span class="extend">'. $dotright_text2 .'</span> ';
			$out.= '<a class="last" href="'. str_replace( '___', $max_page, $link_base ) .'">'. ( $last_page_text ? $last_page_text : $max_page ) .'</a> ';
		}
		// вперед
		if ( $next_text && $paged != $end_page ) 
			$out.= '<a class="next" href="'. str_replace( '___', ($paged+1), $link_base ) .'">'. $next_text .'</a> ';

	$out .= "</div>". $after ."\n";
	
	if ( ! $echo ) 
		return $out;
	echo $out;
}

function single_gallery( $args = array() ) {
	
	$get_posts_args = array(
	"post_parent"    => get_the_ID(),
	"what_to_show"=>"posts",

	"post_type"=>"attachment",
	"orderby"=>"RAND",
	"order"=>"RAND",
	"showposts"=>20,
	"post_mime_type"=>"image/jpeg,image/jpg,image/gif,image/png");
	$posts = get_posts($get_posts_args);
	foreach ($posts as $post)
	{
		$parent = get_post($post->post_parent);
		$image_attributes = wp_get_attachment_image_src( $post->ID );
		$attachment_title = get_the_title( $post->ID );
		$src = $image_attributes[0];
		if(($imgsrc = wp_get_attachment_image($post->ID,'thumb')) 
				&& ($imglink= get_attachment_link($post->ID))
				&& $parent->post_status == "publish")
		{
			echo  "<div class=\"img\"><a href=\"".$imglink ."\">".$imgsrc."</a></div>" ;
		}
	}

}

function single_random_images() {

	global $post;
	$pos = get_post($post);
	if ( $gb = get_children(array(
					'post_parent' => $pos->post_parent,
					'post_type' => 'attachment',
					'numberposts' => 50, 
					'post_mime_type' => 'image',)))
	{
		foreach( $gb as $gbr ) {
			$url=get_attachment_link($gbr->ID);
			$gambar=wp_get_attachment_image( $gbr->ID, 'thumb');
			$attachment_title = get_the_title( $gbr->ID );
			echo "<div class=\"img\"><a href=\"".$url."\">".$gambar."</a></div>";
		}
	}

}

function sidebar_gallery( $args = array() ) {

	$get_posts_args = array(
	"post_parent"    => get_the_ID(),
	"what_to_show"=>"posts",

	"post_type"=>"attachment",
	"orderby"=>"RAND",
	"order"=>"RAND",
	"showposts"=>1,
	"post_mime_type"=>"image/jpeg,image/jpg,image/gif,image/png");
	$nofollow = 'rel="nofollow"';
	$posts = get_posts($get_posts_args);
	foreach ($posts as $post)
	{
		$parent = get_post($post->post_parent);
		if(($imgsrc = wp_get_attachment_image($post->ID,'thumb')) 
				&& ($imglink= get_attachment_link($post->ID))
				&& $parent->post_status == "publish")
		{
			echo  "<a href='" . $imglink . "'>".$imgsrc."</a>" ;
			echo '</span>';
		}
	}

}

function random_images( $args = array() ) {

	global $wpdb;
	$get_posts_args = array(
		'post_parent' => get_the_ID(),
		'what_to_show' => 'posts',
		'post_status' => null,
		'post_type' => 'attachment',
		'orderby' => 'rand',  
		'showposts' => 1,
		'post_mime_type' => 'image/jpeg,image/jpg,image/gif,image/png'
	);
	$nofollow = 'rel="nofollow"';
	$posts = get_posts( $get_posts_args );
	foreach ( $posts as $post ) {
		$parent = get_post( $post->post_parent );
		$attachment_id = $post->ID;
		$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' );
		$img_alt = trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ));
		$img_src = $image_attributes[0];
		if( ( $imgsrc = wp_get_attachment_image( $post->ID, 'medium' ) ) && ( $imglink= get_attachment_link( $post->ID ) ) && $parent->post_status == 'publish') {
			echo  "<a href='".$imglink."'><img src=\"".$image_attributes[0]."\" alt=\"".$img_alt."\" /></a>";
		}
	}
}

function single_random_image() {

	global $wpdb;
	$get_posts_args = array(
		'post_parent' => get_the_ID(),
		'what_to_show' => 'posts',
		'post_status' => null,
		'post_type' => 'attachment',
		'orderby' => 'rand',  
		'showposts' => 1,
		'post_mime_type' => 'image/jpeg,image/jpg,image/gif,image/png'
	);
	$nofollow = 'rel="nofollow"';
	$posts = get_posts( $get_posts_args );
	foreach ( $posts as $post ) {
		$attachment_id = $post->ID;
		$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' );
		$img_alt = trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ));
		$img_src = $image_attributes[0];
		$img_link = get_attachment_link( $post->ID );
		echo  "<a href=\"".$img_link."\">".kama_thumb_img('src='.$img_src.'&w=708&h=708&q=100&alt='.$img_alt.'')."</a>";
	}

}

function add_google_adsense_script() {
    echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9384619306632558" crossorigin="anonymous"></script>';
}
add_action('wp_head', 'add_google_adsense_script');

/*
Plugin Name: Google Tag Manager
Description: Adds Google Tag Manager script to the header of all pages.
Version: 1.0
Author: Your Name
*/

function add_google_tag_manager() {
    ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9Q1DMMWPVD"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-9Q1DMMWPVD');
    </script>
    <?php
}
add_action('wp_head', 'add_google_tag_manager');

// Add meta tags for title and description
function custom_meta_tags() {
    if (is_singular()) {
        global $post;
        $title = get_the_title($post->ID);
        $description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);

        echo '<title>' . esc_html($title) . '</title>' . "\n";
        if ($description) {
            echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        }
    } else if (is_home() || is_front_page()) {
        // Add meta tags for the homepage
        echo '<title>' . get_bloginfo('name') . '</title>' . "\n";
        echo '<meta name="description" content="' . get_bloginfo('description') . '">' . "\n";
    }
}
add_action('wp_head', 'custom_meta_tags');

// Add Open Graph meta tags
function custom_open_graph_tags() {
    if (is_singular()) {
        global $post;
        $title = get_the_title($post->ID);
        $description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

        echo '<meta property="og:title" content="' . esc_html($title) . '">' . "\n";
        if ($description) {
            echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        }
        if ($image) {
            echo '<meta property="og:image" content="' . esc_url($image[0]) . '">' . "\n";
        }
        echo '<meta property="og:url" content="' . esc_url(get_permalink($post->ID)) . '">' . "\n";
    } else if (is_home() || is_front_page()) {
        // Add Open Graph meta tags for the homepage
        echo '<meta property="og:title" content="' . get_bloginfo('name') . '">' . "\n";
        echo '<meta property="og:description" content="' . get_bloginfo('description') . '">' . "\n";
        // Add URL of your image if you have one
        // echo '<meta property="og:image" content="' . esc_url('URL to your image') . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(home_url('/')) . '">' . "\n";
    }
}
add_action('wp_head', 'custom_open_graph_tags');

// Add robots meta tag
function custom_robots_meta_tag() {
    echo '<meta name="robots" content="index, follow">' . "\n";
}
add_action('wp_head', 'custom_robots_meta_tag');


?>