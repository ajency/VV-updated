<?php
/*
Plugin Name: Flexible Recent Posts
Plugin URI: http://steelrat.info/
Description: Displays recent posts using flexible template system.
Version: 1.0.3
Author: SteelRat
Author URI: http://steelrat.info/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
add_action( 'widgets_init', 'frp_widgets_init' );

add_action( 'admin_print_styles-widgets.php', 'frp_admin_print_styles_widgets' );
add_action( 'admin_print_scripts-widgets.php', 'frp_admin_print_scripts_widgets' );

// Checks if plugin version updated.
add_action( 'plugins_loaded', 'frp_update_check' );

add_shortcode( 'frp_title', 'frp_title' );
add_shortcode( 'frp_thumbnail', 'frp_thumbnail' );
add_shortcode( 'frp_excerpt', 'frp_excerpt' );
add_shortcode( 'frp_date', 'frp_date' );
add_shortcode( 'frp_link', 'frp_link' );
add_shortcode( 'frp_author', 'frp_author' );
add_shortcode( 'frp_comments', 'frp_comments' );

add_filter( 'plugin_row_meta', 'frp_plugin_row_meta', 10, 2 );

$frp_global = array(
	'options' => array(
		'version' => '1.0.3',
		'faq_page' => 'http://wordpress.org/extend/plugins/flexible-recent-posts/faq/',
		'feature_request_page' => 'http://frp.idea.informer.com/',
		'themes_url' => plugin_dir_url( __FILE__ ) . 'themes/',
		'themes_dir' => plugin_dir_path( __FILE__ ) . 'themes/'
	),
	'themes' => array(),
	'state' => array()
);

require_once( 'class-recent-posts-widget.php' );

function frp_plugin_row_meta( $plugin_meta, $plugin_file ) {
	global $frp_global;

	if ( strpos( $plugin_file, basename( __FILE__ ) ) ) {
		$plugin_meta[] = '<a href="' . $frp_global['options']['feature_request_page'] . '" title="' . __( 'Visit feature request page', 'frp' ) . '">' . __( 'Feature request', 'frp' ) . '</a>';
		$plugin_meta[] = '<a href="' . $frp_global['options']['faq_page'] . '" title="' . __( 'Visit FAQ page', 'frp' ) . '">' . __( 'FAQ', 'frp' ) . '</a>';
	}

	return $plugin_meta;
}

function frp_admin_print_scripts_widgets() {
	wp_enqueue_script( 'rangyinputs', plugins_url( '', __FILE__ ) . '/scripts/textinputs_jquery.js', array( 'jquery' ) );
	wp_enqueue_script( 'frp', plugins_url( '', __FILE__ ) . '/scripts/frp.min.js', array( 'jquery', 'rangyinputs' ) );

	$options = array(
		'shortcodes' => array(
			'title' => '[frp_title]',
			'thumbnail' => '[frp_thumbnail size="32x32"]',
			'excerpt' => '[frp_excerpt]',
			'date' => '[frp_date format="d.m.Y"]',
			'link' => '[frp_link]',
			'author' => '[frp_author]',
			'comments' => '[frp_comments]',
		),
		'confirmReplace' => __( "Do you want to replace current template with theme's one?", 'frp' )
	);

	wp_localize_script( 'frp', 'frpOptions', array_merge( $options, array( 'themes' => frp_get_themes() ) ) );
}

function frp_admin_print_styles_widgets() {
	// Load native stylesheet for editor buttons.
	wp_print_styles( 'editor-buttons' );

	wp_enqueue_style( 'frp', plugins_url( '', __FILE__ ) . '/css/frp-admin.css' );
}

function frp_widgets_init() {
	load_plugin_textdomain( 'frp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	register_widget( 'RecentPostsWidget' );
}

function frp_title() {
	return get_the_title();
}

/**
 * Gets comments number for current post in the Loop.
 *
 * @param array $atts Parameters:<ul>
 * <li>bool <b>no_text</b> <tt>true</tt> to return only number without text ("1" instead "1 Comment"), <tt>false</tt>
 * otherwise.
 * </ul>
 * @return string Number of comments.
 */
function frp_comments( $atts ) {
	$atts = shortcode_atts( array(
		'no_text' => false,
	), $atts );

	ob_start();
	if ( $atts['no_text'] ) {
		comments_number( '0', '1', '%' );
	} else {
		comments_number();
	}
	$number = ob_get_clean();

	return $number;
}

/**
 * Sets global plugin state variable.
 *
 * @param string $name State name.
 * @param mixed $state State value.
 */
function frp_state_set( $name, $state ) {
	global $frp_global;

	$frp_global[$name] = $state;
}

/**
 * Unsets global plugin state variable.
 *
 * @param string $name State name.
 */
function frp_state_unset( $name ) {
	global $frp_global;

	unset( $frp_global[$name] );
}

/**
 * Gets global plugin state variable.
 *
 * @param string $name State name.
 * @return mixed State value.
 */
function frp_state_get( $name ) {
	global $frp_global;

	return $frp_global[$name];
}

/**
 * Gets excerpt length currently set via state.
 *
 * @return int Excerpt length.
 */
function _frp_excerpt_length() {
	return frp_state_get( 'excerpt_length' );
}

/**
 * Gets excerpt of post that is currently in Loop.
 *
 * @param array $atts Shortcodes and their attributes.
 * @return string Excerpt.
 */
function frp_excerpt( $atts ) {
	$atts = shortcode_atts( array(
		'length' => '',
	), $atts );

	if ( ! empty( $atts['length'] ) ) {
		frp_state_set( 'excerpt_length', $atts['length'] );
		add_filter( 'excerpt_length', '_frp_excerpt_length' );
	}

	$excerpt = get_the_excerpt();

	if ( ! empty( $atts['length'] ) ) {
		remove_filter( 'excerpt_length', '_frp_excerpt_length' );
		frp_state_unset( 'excerpt_length' );
	}

	return $excerpt;
}

function frp_date( $atts ) {
	$atts = shortcode_atts( array(
		'format' => '',
		'time_since' => '0'
	), $atts );

	return ( $atts['time_since'] ) ? frp_time_ago( get_the_time( 'U' ) ) : get_the_date( $atts['format'] );
}

function frp_thumbnail( $atts ) {
	if ( ! current_theme_supports( 'post-thumbnails' ) ) {
		return '';
	}

	$atts = shortcode_atts( array(
		'size' => '32x32',
	), $atts );

	if ( preg_match( '/^(\d+)x(\d+)$/', $atts['size'], $size ) == 1 ) {
		// Remove first element from array. It's matched line. Leave only two sizes.
		array_splice( $size, 0, 1 );
		$atts['size'] = $size;
	}

	return get_the_post_thumbnail( null, $atts['size'] );
}

function frp_link() {
	return get_permalink();
}

function frp_author( $atts ) {
	$atts = shortcode_atts( array(
		'link' => '1',
	), $atts );

	return ( $atts['link'] ) ? get_the_author_link() : get_the_author();
}

/**
 * Returns nice human-readable time elapsed since $time.
 *
 * @param int $time UNIX timestamp.
 * @return string human-readable elapsed time.
 */
function frp_time_ago( $time ) {
	$current_time = current_time( 'timestamp' );
	$value = $current_time - $time;

	$units = array( 'second', 'minute', 'hour' );
	$max = array( 60, 60, 24 );

	foreach ( $units as $id => $unit ) {
		if ( $value < $max[$id] ) {
			$format = apply_filters( 'frp_time_ago_format', _n( '%d ' . $unit . ' ago', '%d ' . $unit . 's ago', $value, 'frp' ), $value, $unit . 's' );

			return sprintf( $format, $value );
		}

		$value = floor( $value / $max[$id] );
	}

	$ago = apply_filters( 'frp_day_month_ago', date( 'j M', $time ), $time );

	$year = date( 'y', $time );

	if ( $year != date( 'y', $current_time ) ) {
		$ago .= ' ' . $year;
	}

	return $ago;
}

/**
 * Returns widget themes list with data.
 *
 * @return array themes list.
 */
function frp_get_themes() {
	global $frp_themes, $frp_global;

	if ( empty( $frp_themes ) ) {
		$themes_dir = glob( $frp_global['options']['themes_dir'] . '*', GLOB_ONLYDIR );

		foreach ( $themes_dir as $path ) {
			$theme_name = basename( $path );
			frp_get_theme( $theme_name );
		}
	}

	return $frp_themes;
}

/**
 * Returns widget theme's data.
 *
 * @param string $theme_name Theme name.
 * @return array theme data.
 */
function frp_get_theme( $theme_name ) {
	global $frp_themes, $frp_global;

	$theme = array();
	if ( ! isset( $frp_themes[$theme_name] ) ) {
		$path = $frp_global['options']['themes_dir'] . $theme_name;
		$json_file = $path . '/' . $theme_name . '.json';
		$template_file = $path . '/template.php';

		if ( is_file( $json_file ) && is_file( $template_file ) ) {
			$theme_info = json_decode( file_get_contents( $json_file ), true );
			$template = file_get_contents( $template_file );

			if ( ! is_null( $theme_info ) && $template != false && ! empty( $theme_info['name'] ) && ! empty( $theme_info['description'] ) ) {
				$theme = array(
					'readable_name' => $theme_info['name'],
					'description' => $theme_info['description'],
					'template' => $template,
					'theme_url' => $frp_global['options']['themes_url'] . $theme_name . '/'
				);

				if ( is_file( $path . '/frp-' . $theme_name . '.css' ) ) {
					$theme['css'] = true;
				}

				if ( is_file( $path . '/screenshot-preview.png' ) ) {
					$theme['preview'] = true;

					if ( is_file( $path . '/screenshot.png' ) ) {
						$theme['screenshot'] = true;
					}
				}

				// Cache theme data.
				$frp_themes[$theme_name] = $theme;
			}
		}
	} else {
		$theme = $frp_themes[$theme_name];
	}

	return $theme;
}

/**
 * Makes plugin data update on version change.
 */
function frp_update_check() {
	global $frp_global;

	$options = get_option( 'frp_data' );
	// Plugin version when there was no upgrade procedure.
	$db_version = '0.3';

	if ( ! is_array( $options ) ) {
		$options = array();
	}

	if ( ! empty( $options['version'] ) ) {
		$db_version = $options['version'];
	}

	if ( '1.0.0' > $db_version ) {
		$widget = new RecentPostsWidget();
		$all_settings = $widget->get_settings();

		foreach ( $all_settings as &$settings ) {
			$settings['terms'] = array();
			$settings['taxonomy'] = 'category';

			if ( empty( $settings['all_categories'] ) && ! empty( $settings['categories'] ) ) {
				$settings['terms'] = $settings['categories'];
			}

			unset ( $settings['all_categories'] );
			unset ( $settings['categories'] );
		}

		$widget->save_settings( $all_settings );
	}

	$options['version'] = $frp_global['options']['version'];
	update_option( 'frp_data', $options );
}