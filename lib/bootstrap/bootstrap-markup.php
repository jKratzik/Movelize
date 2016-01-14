<?php
/**
 * Movelize Child Theme for Genesis.
 *
 * The functions inside this file modify the Genesis HTML markup in order to add Bootstrap CSS class names.
 *
 * WARNING: DO NOT edit this file. Otherwise you will overwrite your changes with future updates.
 * Please do all modifications in functions.php through the actions and filters that are defined in this file or through Genesis hooks.
 *
 * @package Movelize
 * @author  Johann Kratzik
 * @license GPL-2.0+
 * @link    http://www.movelize.com/
 */
 
 
/**
 * Define the Bootstrap container class.
 * The class name can be filtered to apply the Bootstrap "container-fluid" class or to attach additional CSS classes.
 *
 * @since 1.0.0
 */
function mov_container_class() {

	return apply_filters( 'mov_container_class', 'container' );
	
}


add_filter( 'genesis_attr_structural-wrap', 'mov_attr_structural_wrap' );
add_filter( 'genesis_attr_content-sidebar-wrap', 'mov_attr_content_sidebar_wrap' );
/**
 * Filter the structural container wrap CSS class for the main containers.
 *
 * The 2 functions add the Bootstrap "container" class to the wrapping elements inside:
 *   .site-header
 *   .nav-primary
 *   .nav-secondary
 *   .content-sidebar-wrap
 *   .footer-widgets
 *   .site-footer
 *
 * @since 1.0.0
 *
 * Uses mov_container_class()
 *
 * Reference: genesis/lib/functions/markup.php
 */
function mov_attr_structural_wrap( $attributes ) {
	
	$container_class = mov_container_class();
    
	$attributes['class'] = "{$container_class} wrap";
	
	return $attributes;
    
}
function mov_attr_content_sidebar_wrap( $attributes ) {
    
	$container_class = mov_container_class();
	
	$attributes['class'] = "{$container_class} content-sidebar-wrap";
	
	return $attributes;
    
}

add_filter( 'genesis_structural_wrap-header', 'mov_structural_wrap', 10, 2 );
add_filter( 'genesis_structural_wrap-menu-primary', 'mov_structural_wrap', 10, 2 );
add_filter( 'genesis_structural_wrap-menu-secondary', 'mov_structural_wrap', 10, 2 );
add_filter( 'genesis_structural_wrap-footer-widgets', 'mov_structural_wrap', 10, 2 );
add_filter( 'genesis_structural_wrap-footer', 'mov_structural_wrap', 10, 2 );
add_action( 'genesis_before_content', 'mov_content_sidebar_wrap_row_open', 5 );
add_action( 'genesis_after_content', 'mov_content_sidebar_wrap_row_close', 15 );
/**
 * Filter the structural container wrap for the main containers.
 * Puts the openening and closing ".row" with action hooks inside .content-sidebar-wrap
 *
 * Wraps the HTML output of the following elements into a <div> with the Bootstrap ".row" class:
 *   .site-header
 *   .nav-primary
 *   .nav-secondary
 *   .content-sidebar-wrap
 *   .footer-widgets
 *   .site-footer
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/functions/layout.php
 */
function mov_structural_wrap( $output, $original_output ) {
    
	if( 'open' == $original_output ) {
 		$output = $output . '<div class="row">';
	}
    
	if( 'close' == $original_output ) {
		$output = '</div> <!-- .row end -->' . $output;
	}
    
	return $output;
    
}
function mov_content_sidebar_wrap_row_open() {
    
	echo '<div class="row">';
    
}
function mov_content_sidebar_wrap_row_close() {
    
	echo '</div> <!-- .row end -->';
    
}

add_filter( 'genesis_attr_title-area', 'mov_attr_title_area' );
/**
 * Filter the CSS class for the title area.
 * Adds a Bootstrap grid class.
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/functions/markup.php
 */
function mov_attr_title_area( $attributes ) {
    
	global $wp_registered_sidebars;
    
	if ( ( isset( $wp_registered_sidebars['header-right'] ) && is_active_sidebar( 'header-right' ) ) || has_action( 'genesis_header_right' ) ) {
		$attributes['class'] = 'col-sm-6 title-area';
	}
	else {
		$attributes['class'] = 'col-xs-12 title-area';
	}
    
	return $attributes;
}

add_filter( 'genesis_attr_header-widget-area', 'mov_attr_header_widget_area' );
/**
 * Filter the CSS class for the header widget area.
 * Adds a Bootstrap grid class.
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/functions/markup.php
 */
function mov_attr_header_widget_area( $attributes ) {
    
	$attributes['class'] = 'col-sm-6 widget-area header-widget-area';
	return $attributes;
    
}

add_filter( 'genesis_attr_nav-primary', 'mov_attr_nav_primary' );
/**
 * Filter the CSS class for the primary navigation.
 * Adds a Bootstrap grid class and a class to hide the navigation on small screens.
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/functions/markup.php
 */
function mov_attr_nav_primary( $attributes ) {
    
	$attributes['class'] = 'nav-primary hidden-sm hidden-xs';
	return $attributes;
    
}

add_filter( 'genesis_attr_nav-secondary', 'mov_attr_nav_secondary' );
/**
 * Filter the CSS class for the secondary navigation.
 * Adds a Bootstrap grid class and a class to hide the navigation on small screens.
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/functions/markup.php
 */
function mov_attr_nav_secondary( $attributes ) {
    
	$attributes['class'] = 'nav-secondary hidden-sm hidden-xs';
	return $attributes;
    
}

add_filter( 'wp_nav_menu_args', 'mov_nav_menu_args' );
/**
 * Filter the CSS class for the primary and secondary navigation lists.
 * Adds Bootstrap grid classes.
 *
 * @since 1.0.0
 *
 * Reference: https://codex.wordpress.org/Plugin_API/Filter_Reference/wp_nav_menu_args
 */
function mov_nav_menu_args( $args ) {
    
	if( 'primary' == $args['theme_location'] ) {
		$args['menu_class'] = 'col-xs-12 menu genesis-nav-menu menu-primary';
	}
    
	if( 'secondary' == $args['theme_location'] ) {
		$args['menu_class'] = 'col-xs-12 columns menu genesis-nav-menu menu-secondary';
	}
    
	return $args;
}

add_action( 'genesis_before_header', 'mov_mobile_toggle' );
/**
 * Adds markup for the mobile navigation toggle link.
 *
 * @since 1.0.0
 *
 * Uses mov_container_class()
 *
 * Reference: genesis/header.php
 */
function mov_mobile_toggle() {
	
	$container_class = mov_container_class();
    
	$mobile_toggle_output = sprintf( '
		<div class="%s hidden-md hidden-lg toggle-mobile">
			<a href="#mobile-nav" class="icon_menu-square_alt2"></a>
		</div>', $container_class );
		
	echo apply_filters( 'mov_mobile_toggle', $mobile_toggle_output );
    
}

/**
 * Move the secondary sidebar inside the "content-sidebar-wrap" container.
 * The primary and secondary sidebars are positioned with Bootstrap "push" and "pull" CSS classes.
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/framework.php
 */
remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action( 'genesis_after_content', 'genesis_get_sidebar_alt' );

add_filter( 'genesis_attr_content', 'mov_attr_content' );
/**
 * Add Bootstrap grid classes to the content section.
 * Apply classes for different laypout settings.
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/functions/markup.php - genesis/lib/functions/layout.php
 */
function mov_attr_content( $attributes ) {
	
	$layout = genesis_site_layout();
	
	if( 'full-width-content' == $layout ) {
		$column_class = 'col-xs-12';
	}
	
	if( 'content-sidebar' == $layout ) {
		$column_class ='col-md-8';
	}
	
	if( 'sidebar-content' == $layout ) {
		$column_class = 'col-md-8 col-md-push-4';
	}
	
	if( 'content-sidebar-sidebar' == $layout ) {
		$column_class = 'col-lg-7 col-md-8';
	}
	
	if( 'sidebar-sidebar-content' == $layout ) {
		$column_class = 'col-lg-7 col-lg-push-5 col-md-8 col-md-push-4';
	}
	if( 'sidebar-content-sidebar' == $layout ) {
		$column_class = 'col-lg-7 col-lg-push-2 col-md-6 col-md-push-3';
	}
	
	$attributes['class'] = apply_filters( "mov_content_class_{$layout}", $column_class ) . ' content';
	
	return $attributes;
	
}

add_filter( 'genesis_attr_sidebar-primary', 'mov_attr_sidebar_primary' );
/**
 * Add Bootstrap grid classes to the primary sidebar.
 * Apply classes for different laypout settings.
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/functions/markup.php - genesis/lib/functions/layout.php
 */
function mov_attr_sidebar_primary( $attributes ) {
	
	$layout = genesis_site_layout();
	
	if( 'content-sidebar' == $layout ) {
		$column_class = 'col-md-4';
	}
	
	if( 'sidebar-content' == $layout ) {
		$column_class = 'col-md-4 col-md-pull-8';
	}
	
	if( 'content-sidebar-sidebar' == $layout ) {
		$column_class = 'col-lg-3 col-md-4 col-sm-6';
	}
	
	if( 'sidebar-sidebar-content' == $layout ) {
		$column_class = 'col-lg-3 col-lg-pull-5 col-md-4 col-md-pull-8 col-sm-6';
	}
	
	if( 'sidebar-content-sidebar' == $layout ) {
		$column_class = 'col-md-3 col-lg-push-2 col-md-push-3 col-sm-6';
	}
	
	$attributes['class'] = apply_filters( "mov_sidebar-primary_class_{$layout}", $column_class ) . ' sidebar sidebar-primary widget-area';
	
	return $attributes;
	
}

add_filter( 'genesis_attr_sidebar-secondary', 'mov_attr_sidebar_secondary' );
/**
 * Add Bootstrap grid classes to the secondary sidebar.
 * Apply classes for different laypout settings.
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/functions/markup.php - genesis/lib/functions/layout.php
 */
function mov_attr_sidebar_secondary( $attributes ) {
	
	$layout = genesis_site_layout();
	
	if( 'content-sidebar-sidebar' == $layout ) {
		$column_class = 'col-lg-2 col-md-4 col-sm-6 pull-right';
	}
	
	if( 'sidebar-sidebar-content' == $layout ) {
		$column_class = 'col-lg-2 col-lg-pull-10 col-md-4 col-md-pull-8 col-sm-6';
	}
    
	if( 'sidebar-content-sidebar' == $layout ) {
        	$column_class = 'col-lg-2 col-lg-pull-10 col-md-3 col-md-pull-9 col-sm-6';
	}
    
	$attributes['class'] = apply_filters( "mov_sidebar-secondary_class_{$layout}", $column_class ) . ' sidebar sidebar-secondary widget-area';
	
	return $attributes;
	
}

add_filter( 'genesis_footer_widget_areas', 'mov_footer_widget_areas' );
/**
 * Filters the footer widget area because with the Genesis function it's not possible to apply Bootstrap grid classes to the widgets dynamically in a proper way.
 * Defines an action to insert the footer widgets.
 *
 * See example code in functions.php
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/structure/footer.php
 */
function mov_footer_widget_areas( $output ) {
	
	genesis_markup( array(
		'html5'   => '<div %s>' . genesis_sidebar_title( 'Footer' ),
		'xhtml'   => '<div id="footer-widgets" class="footer-widgets">',
		'context' => 'footer-widgets'
	) );
	echo genesis_structural_wrap( 'footer-widgets', 'open', 0 );

	do_action( 'mov_footer_widgets_output' );	
	
	echo genesis_structural_wrap( 'footer-widgets', 'close', 0 );
	echo '</div>';
	
}

add_filter( 'genesis_footer_output', 'mov_footer_output' );
/**
 * Basic filter for the site footer output to insert a Bootstrap grid class.
 * Developers need to hook into the Genesis filter if the output needs to be modified further.
 *
 * @since 1.0.0
 *
 * Reference: genesis/lib/structure/footer.php
 */
function mov_footer_output( $output ) {
	
	return '<div class="col-xs-12">' . $output . '</div>';
	
}
?>
