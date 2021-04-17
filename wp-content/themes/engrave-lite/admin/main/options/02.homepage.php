<?php
/**
 * Homepage functions.
 *
 * @package ThinkUpThemes
 */

/* ----------------------------------------------------------------------------------
	ENABLE SLIDER - HOMEPAGE & INNER-PAGES
---------------------------------------------------------------------------------- */

// Add full width slider class to body
function thinkup_input_sliderclass($classes){

// Get theme options values.
$thinkup_homepage_sliderswitch      = thinkup_var ( 'thinkup_homepage_sliderswitch' );
$thinkup_homepage_sliderpresetwidth = thinkup_var ( 'thinkup_homepage_sliderpresetwidth' );

	if ( is_front_page() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' or $thinkup_homepage_sliderswitch == 'option4' ) {
			if ( empty( $thinkup_homepage_sliderpresetwidth ) or $thinkup_homepage_sliderpresetwidth == '1' ) {
				$classes[] = 'slider-full';
			} else {
				$classes[] = 'slider-boxed';
			}
		}
	}
	return $classes;
}
add_action( 'body_class', 'thinkup_input_sliderclass');


/* ----------------------------------------------------------------------------------
	ENABLE HOMEPAGE SLIDER
---------------------------------------------------------------------------------- */

// Content for slider layout - Standard
function thinkup_input_sliderhomepage() {

// Get theme options values.
$thinkup_homepage_sliderimage1_image = thinkup_var ( 'thinkup_homepage_sliderimage1_image', 'url' );
$thinkup_homepage_sliderimage1_title = thinkup_var ( 'thinkup_homepage_sliderimage1_title' );
$thinkup_homepage_sliderimage1_desc  = thinkup_var ( 'thinkup_homepage_sliderimage1_desc' );
$thinkup_homepage_sliderimage1_link  = thinkup_var ( 'thinkup_homepage_sliderimage1_link' );
$thinkup_homepage_sliderimage2_image = thinkup_var ( 'thinkup_homepage_sliderimage2_image', 'url' );
$thinkup_homepage_sliderimage2_title = thinkup_var ( 'thinkup_homepage_sliderimage2_title' );
$thinkup_homepage_sliderimage2_desc  = thinkup_var ( 'thinkup_homepage_sliderimage2_desc' );
$thinkup_homepage_sliderimage2_link  = thinkup_var ( 'thinkup_homepage_sliderimage2_link' );
$thinkup_homepage_sliderimage3_image = thinkup_var ( 'thinkup_homepage_sliderimage3_image', 'url' );
$thinkup_homepage_sliderimage3_title = thinkup_var ( 'thinkup_homepage_sliderimage3_title' );
$thinkup_homepage_sliderimage3_desc  = thinkup_var ( 'thinkup_homepage_sliderimage3_desc' );
$thinkup_homepage_sliderimage3_link  = thinkup_var ( 'thinkup_homepage_sliderimage3_link' );

	// Set output variable to avoid php errors
	$slide1_link = NULL;
	$slide2_link = NULL;
	$slide3_link = NULL;

	// Get url of featured images in slider pages
	$slide1_image_url = $thinkup_homepage_sliderimage1_image;
	$slide2_image_url = $thinkup_homepage_sliderimage2_image;
	$slide3_image_url = $thinkup_homepage_sliderimage3_image;

	// Get titles of slider pages
	$slide1_title = $thinkup_homepage_sliderimage1_title;
	$slide2_title = $thinkup_homepage_sliderimage2_title;
	$slide3_title = $thinkup_homepage_sliderimage3_title;

	// Get descriptions (excerpt) of slider pages
	$slide1_desc = $thinkup_homepage_sliderimage1_desc;
	$slide2_desc = $thinkup_homepage_sliderimage2_desc;
	$slide3_desc = $thinkup_homepage_sliderimage3_desc;

	// Get url of slider pages
	if( ! empty( $thinkup_homepage_sliderimage1_link ) ) {
		$slide1_link = get_permalink( $thinkup_homepage_sliderimage1_link );
	}
	if( ! empty( $thinkup_homepage_sliderimage2_link ) ) {
		$slide2_link = get_permalink( $thinkup_homepage_sliderimage2_link );
	}
	if( ! empty( $thinkup_homepage_sliderimage3_link ) ) {
		$slide3_link = get_permalink( $thinkup_homepage_sliderimage3_link );
	}

	// Create array for slider content
	$thinkup_homepage_sliderpage = array(
		array(
			'slide_image_url'   => $slide1_image_url,
			'slide_title'       => $slide1_title,
			'slide_desc'        => $slide1_desc,
			'slide_link'        => $slide1_link
		),
		array(
			'slide_image_url'   => $slide2_image_url,
			'slide_title'       => $slide2_title,
			'slide_desc'        => $slide2_desc,
			'slide_link'        => $slide2_link
		),
		array(
			'slide_image_url'   => $slide3_image_url,
			'slide_title'       => $slide3_title,
			'slide_desc'        => $slide3_desc,
			'slide_link'        => $slide3_link
		),
	);

	foreach ($thinkup_homepage_sliderpage as $slide) {

		if ( ! empty( $slide['slide_image_url'] ) ) {

			// Get url of background image or set video overlay image
			$slide_image = 'background: url(' . esc_url( $slide['slide_image_url'] ) . ') no-repeat center; background-size: cover;';

			// Used for slider image alt text
			if ( ! empty( $slide['slide_title'] ) ) {
				$slide_alt = $slide['slide_title'];
			} else {
				$slide_alt = esc_html__( 'Slider Image', 'engrave-lite' );
			}

			echo '<li>',
				 '<img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="' . esc_attr( $slide_image ) . '" alt="' . esc_attr( $slide_alt ) . '" />',
				 '<div class="rslides-content">',
				 '<div class="wrap-safari">',
				 '<div class="rslides-content-inner">',
				 '<div class="featured">';

				if ( ! empty( $slide['slide_title'] ) ) {

					// Wrap text in <span> tags
					$slide['slide_title'] = '<span>' . esc_html( $slide['slide_title'] ) . '</span>';
					$slide['slide_title'] = str_replace( '<br />', '</span><br /><span>', $slide['slide_title'] );
					$slide['slide_title'] = str_replace( '<br/>', '</span><br/><span>', $slide['slide_title'] );

					echo '<div class="featured-title">',
						 wp_kses_post( $slide['slide_title'] ),
						 '</div>';
				}
				if ( ! empty( $slide['slide_desc'] ) ) {
					$slide_desc = '<p><span>' . esc_html( wp_strip_all_tags( $slide['slide_desc'] ) ) . '</span></p>';

					// Wrap text in <span> tags
					$slide_desc = str_replace( '<br />', '</span><br /><span>', $slide_desc );
					$slide_desc = str_replace( '<br/>', '</span><br/><span>', $slide_desc );

					echo '<div class="featured-excerpt">',
						 wp_kses_post( $slide_desc ),
						 '</div>';
				}
				if ( ! empty( $slide['slide_link'] ) ) {

					if ( empty( $slide['slide_button'] ) ) {
						$slide['slide_button'] = esc_html__( 'Read More', 'engrave-lite' );
					}

					echo '<div class="featured-link">',
						 '<a href="' . esc_url( $slide['slide_link'] ) . '"><span>' . esc_html( $slide['slide_button'] ) . '</span></a>',
						 '</div>';
				}

			echo '</div>',
				  '</div>',
				  '</div>',
				  '</div>',
				  '</li>';
		}
	}
}

// Add Slider - Homepage
function thinkup_input_sliderhome() {

// Get theme options values.
$thinkup_homepage_sliderswitch       = thinkup_var ( 'thinkup_homepage_sliderswitch' );
$thinkup_homepage_sliderimage1_image = thinkup_var ( 'thinkup_homepage_sliderimage1_image', 'url' );
$thinkup_homepage_sliderimage2_image = thinkup_var ( 'thinkup_homepage_sliderimage2_image', 'url' );
$thinkup_homepage_sliderimage3_image = thinkup_var ( 'thinkup_homepage_sliderimage3_image', 'url' );

$slider_default = NULL;

	if ( is_front_page() ) {

		// Set default slider
		$slider_default .= '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_stylesheet_directory_uri() ) . '/images/slideshow/slide_demo1.png) no-repeat center; background-size: cover;" alt="' . esc_attr__( 'Demo Image', 'engrave-lite' ) . '" /></li>';
		$slider_default .= '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_template_directory_uri() ) . '/images/slideshow/slide_demo2.png) no-repeat center; background-size: cover;" alt="' . esc_attr__( 'Demo Image', 'engrave-lite' ) . '" /></li>';
		$slider_default .= '<li><img src="' . esc_url( get_template_directory_uri() ) . '/images/transparent.png" style="background: url(' . esc_url( get_template_directory_uri() ) . '/images/slideshow/slide_demo3.png) no-repeat center; background-size: cover;" alt="' . esc_attr__( 'Demo Image', 'engrave-lite' ) . '" /></li>';

		if ( ( current_user_can( 'edit_theme_options' ) and empty( $thinkup_homepage_sliderswitch ) ) or $thinkup_homepage_sliderswitch == 'option1' ) {

			echo '<div id="slider"><div id="slider-core">';
			echo '<div class="rslides-container" data-speed="6000"><div class="rslides-inner"><ul class="slides">';
				echo $slider_default;
			echo '</ul></div></div>';
			echo '</div></div>';

		} else if ( $thinkup_homepage_sliderswitch == 'option2' ) {

			echo '';

		} else if ( $thinkup_homepage_sliderswitch == 'option3' ) {

			echo '';

		} else if ( $thinkup_homepage_sliderswitch == 'option4' ) {

			// Check if page slider has been set
			if( empty( $thinkup_homepage_sliderimage1_image ) and empty( $thinkup_homepage_sliderimage2_image ) and empty( $thinkup_homepage_sliderimage3_image ) ) {

				echo '<div id="slider"><div id="slider-core">';
				echo '<div class="rslides-container" data-speed="6000"><div class="rslides-inner"><ul class="slides">';
					echo $slider_default;
				echo '</ul></div></div>';
				echo '</div></div>';

			} else {

				echo '<div id="slider"><div id="slider-core">';
				echo '<div class="rslides-container" data-speed="6000"><div class="rslides-inner"><ul class="slides">';
					thinkup_input_sliderhomepage();
				echo '</ul></div></div>';
				echo '</div></div>';
				
			}

		}
	}
}

// Add ThinkUpSlider Height - Homepage
function thinkup_input_sliderhomeheight() {

// Get theme options values.
$thinkup_homepage_sliderswitch       = thinkup_var ( 'thinkup_homepage_sliderswitch' );
$thinkup_homepage_sliderpresetheight = thinkup_var ( 'thinkup_homepage_sliderpresetheight' );

	if ( empty( $thinkup_homepage_sliderpresetheight ) ) $thinkup_homepage_sliderpresetheight = '350';

	if ( is_front_page() ) {
		if ( empty( $thinkup_homepage_sliderswitch ) or $thinkup_homepage_sliderswitch == 'option1' or $thinkup_homepage_sliderswitch == 'option4' ) {
		echo 	"\n" .'<style type="text/css">' . "\n",
			'#slider .rslides, #slider .rslides li { height: ' . esc_html( $thinkup_homepage_sliderpresetheight ) . 'px; max-height: ' . esc_html( $thinkup_homepage_sliderpresetheight ) . 'px; }' . "\n",
			'#slider .rslides img { height: 100%; max-height: ' . esc_html( $thinkup_homepage_sliderpresetheight ) . 'px; }' . "\n",
			'</style>' . "\n";
		}
	}
}
add_action( 'wp_head','thinkup_input_sliderhomeheight', '13' );


//----------------------------------------------------------------------------------
//	ENABLE HOMEPAGE CONTENT
//----------------------------------------------------------------------------------

function thinkup_input_homepagesection() {

// Get theme options values.
$thinkup_homepage_sectionswitch  = thinkup_var ( 'thinkup_homepage_sectionswitch' );
$thinkup_homepage_section1_icon  = thinkup_var ( 'thinkup_homepage_section1_icon' );
$thinkup_homepage_section1_title = thinkup_var ( 'thinkup_homepage_section1_title' );
$thinkup_homepage_section1_desc  = thinkup_var ( 'thinkup_homepage_section1_desc' );
$thinkup_homepage_section1_link  = thinkup_var ( 'thinkup_homepage_section1_link' );
$thinkup_homepage_section2_icon  = thinkup_var ( 'thinkup_homepage_section2_icon' );
$thinkup_homepage_section2_title = thinkup_var ( 'thinkup_homepage_section2_title' );
$thinkup_homepage_section2_desc  = thinkup_var ( 'thinkup_homepage_section2_desc' );
$thinkup_homepage_section2_link  = thinkup_var ( 'thinkup_homepage_section2_link' );
$thinkup_homepage_section3_icon  = thinkup_var ( 'thinkup_homepage_section3_icon' );
$thinkup_homepage_section3_title = thinkup_var ( 'thinkup_homepage_section3_title' );
$thinkup_homepage_section3_desc  = thinkup_var ( 'thinkup_homepage_section3_desc' );
$thinkup_homepage_section3_link  = thinkup_var ( 'thinkup_homepage_section3_link' );

	// Set default values for icons
	if ( empty( $thinkup_homepage_section1_icon ) ) $thinkup_homepage_section1_icon = __( 'fa fa-thumbs-up', 'engrave-lite' );
	if ( empty( $thinkup_homepage_section2_icon ) ) $thinkup_homepage_section2_icon = __( 'fa fa-desktop', 'engrave-lite' );
	if ( empty( $thinkup_homepage_section3_icon ) ) $thinkup_homepage_section3_icon = __( 'fa fa-gears', 'engrave-lite' );

	// Set default values for titles
	if ( empty( $thinkup_homepage_section1_title ) ) $thinkup_homepage_section1_title = __( 'Section 1', 'engrave-lite' );
	if ( empty( $thinkup_homepage_section2_title ) ) $thinkup_homepage_section2_title = __( 'Section 2', 'engrave-lite' );
	if ( empty( $thinkup_homepage_section3_title ) ) $thinkup_homepage_section3_title = __( 'Section 3', 'engrave-lite' );

	// Set default values for descriptions
	if ( empty( $thinkup_homepage_section1_desc ) ) 
	$thinkup_homepage_section1_desc = __( 'Easily change the content of this box using the Homepage section of the built-in theme options panel.', 'engrave-lite' );

	if ( empty( $thinkup_homepage_section2_desc ) ) 
	$thinkup_homepage_section2_desc = __( 'You can even change the icon at the top of this box. There&#39;s hundreds to choose from. Simply pick one.', 'engrave-lite' );

	if ( empty( $thinkup_homepage_section3_desc ) ) 
	$thinkup_homepage_section3_desc = __( 'Link this entire box to any page on your site. There&#39;s even a smooth color change when a user hovers this box.', 'engrave-lite' );

	// Get page names for links
	if ( !empty( $thinkup_homepage_section1_link ) ) $thinkup_homepage_section1_link = get_permalink( $thinkup_homepage_section1_link );
	if ( !empty( $thinkup_homepage_section2_link ) ) $thinkup_homepage_section2_link = get_permalink( $thinkup_homepage_section2_link );
	if ( !empty( $thinkup_homepage_section3_link ) ) $thinkup_homepage_section3_link = get_permalink( $thinkup_homepage_section3_link );


	if ( is_front_page() ) {
		if ( ( current_user_can( 'edit_theme_options' ) and empty( $thinkup_homepage_sectionswitch ) ) or $thinkup_homepage_sectionswitch == '1' ) {

		echo '<div id="section-home"><div id="section-home-inner">';

			echo '<div class="section1 one_third">',
					'<a href="' . esc_url( $thinkup_homepage_section1_link ) . '">',
					'<div class="entry-header">',
					'<span><i class="' . esc_attr( $thinkup_homepage_section1_icon ) . '"></i></span>',
					'</div>',
					'<div class="entry-content">',
					'<h3>' . esc_html( $thinkup_homepage_section1_title ) . '</h3>' . wpautop( wp_strip_all_tags( esc_html( $thinkup_homepage_section1_desc ) ) ),
					'</div>',
					'</a>',
				'</div>';

			echo '<div class="section2 one_third">',
					'<a href="' . esc_url( $thinkup_homepage_section2_link ) . '">',
					'<div class="entry-header">',
					'<span><i class="' . esc_attr( $thinkup_homepage_section2_icon ) . '"></i></span>',
					'</div>',
					'<div class="entry-content">',
					'<h3>' . esc_html( $thinkup_homepage_section2_title ) . '</h3>' . wpautop( wp_strip_all_tags( esc_html( $thinkup_homepage_section2_desc ) ) ),
					'</div>',
					'</a>',
				'</div>';

			echo '<div class="section3 one_third last">',
					'<a href="' . esc_url( $thinkup_homepage_section3_link ) . '">',
					'<div class="entry-header">',
					'<span><i class="' . esc_attr( $thinkup_homepage_section3_icon ) . '"></i></span>',
					'</div>',
					'<div class="entry-content">',
					'<h3>' . esc_html( $thinkup_homepage_section3_title ) . '</h3>' . wpautop( wp_strip_all_tags( esc_html( $thinkup_homepage_section3_desc ) ) ),
					'</div>',
					'</a>',
				'</div>';

		echo '<div class="clearboth"></div></div></div>';

		}
	}
}


//----------------------------------------------------------------------------------
//	CALL TO ACTION - INTRO
//----------------------------------------------------------------------------------

function thinkup_input_ctaintro() {

// Get theme options values.
$thinkup_homepage_introswitch       = thinkup_var ( 'thinkup_homepage_introswitch' );
$thinkup_homepage_introaction       = thinkup_var ( 'thinkup_homepage_introaction' );
$thinkup_homepage_introactionteaser = thinkup_var ( 'thinkup_homepage_introactionteaser' );
$thinkup_homepage_introactionbutton = thinkup_var ( 'thinkup_homepage_introactionbutton' );
$thinkup_homepage_introactionlink   = thinkup_var ( 'thinkup_homepage_introactionlink' );
$thinkup_homepage_introactionpage   = thinkup_var ( 'thinkup_homepage_introactionpage' );
$thinkup_homepage_introactioncustom = thinkup_var ( 'thinkup_homepage_introactioncustom' );

	if ( $thinkup_homepage_introswitch == '1' and is_front_page() and ! empty( $thinkup_homepage_introaction ) ) {
		echo '<div id="introaction"><div id="introaction-core">';
		if (empty( $thinkup_homepage_introactionbutton ) ) {
			if ( empty( $thinkup_homepage_introactionteaser ) ) {
				echo	'<div class="action-text">
						<h3>' . esc_html( $thinkup_homepage_introaction ) . '</h3>
						</div>';
				} else {
				echo	'<div class="action-text action-teaser">
						<h3>' . esc_html( $thinkup_homepage_introaction ) . '</h3>
						<p>' . esc_html( $thinkup_homepage_introactionteaser ) . '</p>
						</div>';
				}
		} else if ( ! empty( $thinkup_homepage_introactionbutton ) ) {
			if ( empty( $thinkup_homepage_introactionteaser ) ) {
				echo	'<div class="action-text three_fourth">
						<h3>' . esc_html( $thinkup_homepage_introaction ) . '</h3>
						</div>';
				} else {
				echo	'<div class="action-text three_fourth action-teaser">
						<h3>' . esc_html( $thinkup_homepage_introaction ) . '</h3>
						<p>' . esc_html( $thinkup_homepage_introactionteaser ) . '</p>
						</div>';
				}
			if ( $thinkup_homepage_introactionlink == 'option1' ) {
				echo '<div class="action-button one_fourth last"><a href="' . esc_url( get_permalink( $thinkup_homepage_introactionpage ) ) . '"><h4 class="themebutton">';
				echo esc_html( $thinkup_homepage_introactionbutton );
				echo '</h4></a></div>';
			} else if ( $thinkup_homepage_introactionlink == 'option2' ) {
				echo '<div class="action-button one_fourth last"><a href="' . esc_url( $thinkup_homepage_introactioncustom ) . '"><h4 class="themebutton">';
				echo esc_html( $thinkup_homepage_introactionbutton );
				echo '</h4></a></div>';
			} else if ( $thinkup_homepage_introactionlink == 'option3' or empty( $thinkup_homepage_introactionlink ) ) {
				echo '<div class="action-button one_fourth last"><h4 class="themebutton">';
				echo esc_html( $thinkup_homepage_introactionbutton );
				echo '</h4></div>';
			}
		}
		echo '</div></div>';
	}
}


?>