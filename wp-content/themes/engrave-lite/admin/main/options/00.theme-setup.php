<?php
/**
 * Theme setup functions.
 *
 * @package ThinkUpThemes
 */


//----------------------------------------------------------------------------------
//	ADD CUSTOM HOOKS
//----------------------------------------------------------------------------------

// Used at top of header.php
function thinkup_hook_header() { 
	do_action('thinkup_hook_header');
}

// Used at top of header.php within the body tag
function thinkup_bodystyle() { 
	do_action('thinkup_bodystyle');
}


//----------------------------------------------------------------------------------
//	ADD PAGE TITLE
//----------------------------------------------------------------------------------

function thinkup_title_select() {
global $post;

	if ( is_page() ) {
		printf( '%s', esc_html( get_the_title() ) );
	} elseif ( is_attachment() ) {
		printf( esc_html__( 'Blog Post Image: %s', 'engrave-lite' ), esc_html( get_the_title( $post->post_parent ) ) );
	} else if ( is_single() ) {
		printf( '%s', html_entity_decode( esc_html( get_the_title() ) ) );
	} else if ( is_search() ) {
		printf( esc_html__( 'Search Results: %s', 'engrave-lite' ), get_search_query() );
	} else if ( is_404() ) {
		printf( esc_html__( 'Page Not Found', 'engrave-lite' ) );
	} else if ( is_category() ) {
		printf( esc_html__( 'Category Archives: %s', 'engrave-lite' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		printf( esc_html__( 'Tag Archives: %s', 'engrave-lite' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		the_post();
		printf( esc_html__( 'Author Archives: %s', 'engrave-lite' ), get_the_author() );
		rewind_posts();
	} elseif ( is_day() ) {
		printf( esc_html__( 'Daily Archives: %s', 'engrave-lite' ), get_the_date() );
	} elseif ( is_month() ) {
		printf( esc_html__( 'Monthly Archives: %s', 'engrave-lite' ), get_the_date( 'F Y' ) );
	} elseif ( is_year() ) {
		printf( esc_html__( 'Yearly Archives: %s', 'engrave-lite' ), get_the_date( 'Y' ) );
	} elseif ( is_post_type_archive( 'portfolio' ) ) {
		printf( esc_html__( 'Portfolio', 'engrave-lite' ) );
	} elseif ( is_archive() ) {
		printf( esc_html( get_the_archive_title() ) );
	} elseif ( is_tax() ) {
		printf( esc_html( get_queried_object()->name ) );
	} elseif ( thinkup_check_isblog() ) {
		printf( esc_html__( 'Blog', 'engrave-lite' ) );
	} else {
		printf( '%s', html_entity_decode( esc_html( get_the_title() ) ) );
	}
}

// Remove "archive" text from custom post type archive pages
function thinkup_title_select_cpt($title) {
    if ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}
	return $title;
};
add_filter( 'get_the_archive_title', 'thinkup_title_select_cpt' );


//----------------------------------------------------------------------------------
//	ADD BREADCRUMBS FUNCTIONALITY
//----------------------------------------------------------------------------------

function thinkup_input_breadcrumb() {
$thinkup_general_breadcrumbdelimeter = thinkup_var ( 'thinkup_general_breadcrumbdelimeter' );

	if ( empty( $thinkup_general_breadcrumbdelimeter ) ) {
		$delimiter = '<span class="delimiter">/</span>';
	}
	else if ( ! empty( $thinkup_general_breadcrumbdelimeter ) ) {
		$delimiter = '<span class="delimiter"> ' . esc_html( $thinkup_general_breadcrumbdelimeter ) . ' </span>';
	}

	$delimiter_inner   =   '<span class="delimiter_core"> &bull; </span>';
	$main              =   esc_html__( 'Home', 'engrave-lite' );
	$maxLength         =   30;

	// Archive variables
	$arc_year       =   get_the_time('Y');
	$arc_month      =   get_the_time('F');
	$arc_day        =   get_the_time('d');
	$arc_day_full   =   get_the_time('l');  

	// URL variables
	$url_year    =   get_year_link($arc_year);
	$url_month   =   get_month_link($arc_year,$arc_month);

	// Display breadcumbs if NOT the home page
	if ( !is_front_page() ) {
		echo '<div id="breadcrumbs"><div id="breadcrumbs-core">';
		global $post, $cat;
		$homeLink = home_url( '/' );
		echo '<a href="' . esc_url( $homeLink ) . '">' . esc_html( $main ) . '</a>' . $delimiter;    

		// Display breadcrumbs for single post
		if ( is_single() ) {
			$category = get_the_category();
			$num_cat = count($category);
			if ($num_cat <=1) {
				echo ' ' . esc_html( get_the_title() );
			} else {

				// Count Total categories
				foreach( get_the_category() as $category) {
					$count_categories++;
				}
				
				// Output Categories
				foreach( get_the_category() as $category) {
					$count_loop++;

					if ( $count_loop < $count_categories ) {
						echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->cat_name ) . '</a>' . $delimiter_inner; 
					} else {
						echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->cat_name ) . '</a>'; 
					}
				}
				
				if (strlen(get_the_title()) >= $maxLength) {
					echo ' ' . $delimiter . esc_html( trim( substr( get_the_title(), 0, $maxLength ) ) ) . ' &hellip;';
				} else {
					echo ' ' . $delimiter . esc_html( get_the_title() );
				}
			}
		} elseif (is_category()) {
			esc_html_e( 'Archive Category: ', 'engrave-lite' ) . get_category_parents($cat, true,' ' . $delimiter . ' ') ;
		} elseif ( is_tag() ) {
			esc_html_e( 'Posts Tagged: ', 'engrave-lite' ) . single_tag_title("", false) . '"';
		} elseif ( is_day()) {
			echo '<a href="' . esc_url( $url_year ) . '">' . esc_html( $arc_year ) . '</a> ' . $delimiter . ' ';
			echo '<a href="' . esc_url( $url_month ) . '">' . esc_html( $arc_month ) . '</a> ' . $delimiter . esc_html( $arc_day ) . ' (' . esc_html( $arc_day_full ) . ')';
		} elseif ( is_month() ) {
			echo '<a href="' . esc_url( $url_year ) . '">' . esc_html( $arc_year ). '</a> ' . $delimiter . esc_html( $arc_month );
		} elseif ( is_year() ) {
			echo esc_html( $arc_year );
		} elseif ( is_search() ) {
			esc_html_e( 'Search Results for: ', 'engrave-lite' ) . esc_html( get_search_query() ) . '"';
		} elseif ( is_page() && !$post->post_parent ) {
			echo esc_html( get_the_title() );
		} elseif ( is_page() && $post->post_parent ) {
			$post_array = get_post_ancestors( $post );
			krsort( $post_array ); 
			foreach( $post_array as $key=>$postid ){
				$post_ids = get_post( $postid );
				$title = $post_ids->post_title;
				echo '<a href="' . esc_url( get_permalink( $post_ids ) ) . '">' . esc_html( $title ) . '</a>' . $delimiter;
			}
			the_title();
		} elseif ( is_author() ) {
			global $author;
			$user_info = get_userdata($author);
			esc_html_e( 'Archived Article(s) by Author: ', 'engrave-lite' ) . esc_html( $user_info->display_name );
		} elseif ( is_404() ) {
			esc_html_e( 'Error 404 - Not Found.', 'engrave-lite' );
		} elseif ( is_archive() ) {
			echo esc_html( get_the_archive_title() );
		} elseif( is_tax() ) {
			echo esc_html( get_queried_object()->name );
		} elseif ( thinkup_check_isblog() ) {
			esc_html_e( 'Blog', 'engrave-lite' );
		} else {
			echo html_entity_decode( esc_html( get_the_title() ) );
		}

		echo '</div></div>';
    }
}


//----------------------------------------------------------------------------------
//	REMOVE NON VALID REL CATEGORY TAGS
//----------------------------------------------------------------------------------

function thinkup_removerel_category( $text ) { 
	$text = str_replace( 'rel="category"', "", $text );
	return $text; 
};
add_filter( 'the_category', 'thinkup_removerel_category' );  


//----------------------------------------------------------------------------------
//	ADD CUSTOM FEATURED IMAGE SIZES
//----------------------------------------------------------------------------------

if ( ! function_exists( 'thinkup_input_addimagesizes' ) ) {
	function thinkup_input_addimagesizes() {

		// 1 Column Layout
		add_image_size( 'column1-1/3', 1140, 380, true );
		add_image_size( 'column1-2/3', 1140, 760, true );
		add_image_size( 'column1-2/5', 1140, 456, true );

		// 2 Column Layout
		add_image_size( 'column2-1/2', 570, 285, true );
		add_image_size( 'column2-2/3', 570, 380, true );
		add_image_size( 'column2-2/5', 570, 228, true );
		add_image_size( 'column2-3/5', 570, 342, true );

		// 3 Column Layout
		add_image_size( 'column3-2/3', 380, 254, true );

		// 4 Column Layout
		add_image_size( 'column4-2/3', 285, 190, true );
	}
	add_action( 'after_setup_theme', 'thinkup_input_addimagesizes' );
}

if ( ! function_exists( 'thinkup_input_showimagesizes' ) ) {
	function thinkup_input_showimagesizes($sizes) {

		// 1 Column Layout
		$sizes['column1-1/3'] = __( 'Full - 1:3', 'engrave-lite' );
		$sizes['column1-2/3'] = __( 'Full - 2:3', 'engrave-lite' );
		$sizes['column1-2/5'] = __( 'Full - 2:5', 'engrave-lite' );

		// 2 Column Layout
		$sizes['column2-1/2'] = __( 'Half - 1:2', 'engrave-lite' );
		$sizes['column2-2/3'] = __( 'Half - 2:3', 'engrave-lite' );
		$sizes['column2-2/5'] = __( 'Half - 2:5', 'engrave-lite' );
		$sizes['column2-3/5'] = __( 'Half - 3:5', 'engrave-lite' );

		// 3 Column Layout
		$sizes['column3-2/3'] = __( 'Third - 2:3', 'engrave-lite' );

		// 4 Column Layout
		$sizes['column4-2/3'] = __( 'Quarter - 2:3', 'engrave-lite' );

		return $sizes;
	}
	add_filter('image_size_names_choose', 'thinkup_input_showimagesizes');
}


//----------------------------------------------------------------------------------
//	CHANGE FALLBACK WP_PAGE_MENU CLASSES TO MATCH WP_NAV_MENU CLASSES
//----------------------------------------------------------------------------------

function thinkup_input_menuclass( $ulclass ) {

	// Add menu class to list
	$ulclass = preg_replace( '/<ul>/', '<ul class="menu">', $ulclass, 1 );
	$ulclass = str_replace( 'children', 'sub-menu', $ulclass );

	// Remove div wrapper
	$ulclass = str_replace( '<div class="menu">', '', $ulclass );
	$ulclass = str_replace( '</div>', '', $ulclass );

	return preg_replace('/<div (.*)>(.*)<\/div>/iU', '$2', $ulclass );
}
add_filter( 'wp_page_menu', 'thinkup_input_menuclass' );


//----------------------------------------------------------------------------------
//	DETERMINE IF THE PAGE IS A BLOG - USEFUL FOR HOMEPAGE BLOG.
//----------------------------------------------------------------------------------

// Credit to: http://www.poseidonwebstudios.com/web-development/wordpress-is_blog-function/
function thinkup_check_isblog() {
 
    global $post;
 
    //Post type must be 'post'.
    $post_type = get_post_type($post);
 
    //Check all blog-related conditional tags, as well as the current post type,
    //to determine if we're viewing a blog page.
    return (
        ( is_home() || is_archive() )
        && ($post_type == 'post')
    ) ? true : false ;
 
}


//----------------------------------------------------------------------------------
//	FIX JETPACK PHOTON IMAGE LOAD ISSUE - DISABLE CACHING FOR SPECIFIC IMAGES 
//----------------------------------------------------------------------------------

function thinkup_photon_exception( $val, $src, $tag ) {
        if ( $src == get_template_directory_uri() . '/images/transparent.png' ) {
                return true;
        }
        return $val;
}
add_filter( 'jetpack_photon_skip_image', 'thinkup_photon_exception', 10, 3 );

