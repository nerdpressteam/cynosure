<?php
/**
 * Plugin Name: 	Cynosure
 * Description: 	Adds an animated highlight feature to an in-content <div> as it scrolls by, making it the center of attention.
 * Version:			1.0
 * Author: 			NerdPress
 * Author URI: 		https://www.nerdpress.net/
 * License:         GPL v3
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 */

function cynosure_enqueue_scripts() {
    wp_register_script('cynosure_script', plugins_url('/cynosure.js', __FILE__), array(), '1.0', true);
    wp_enqueue_script('cynosure_script');

    $cynosure_settings	= get_option( 'cynosure' );

	$color				= esc_html( $cynosure_settings[color] );
    list($r, $g, $b)	= sscanf($color, "#%02x%02x%02x");

    $settings = array(
        'selector' => $cynosure_settings[selector],
        'color' => "rgba($r, $g, $b, 0.7)",
		'debug' => $cynosure_settings[debug_mode]
    );
    wp_localize_script('cynosure_script', 'cynosureSettings', $settings);
}

add_action('wp_enqueue_scripts', 'cynosure_enqueue_scripts');

function cynosure_custom_css() {
	
    $cynosure_settings	= get_option( 'cynosure' );
    
    echo '<style>
	'. esc_html( $cynosure_settings[selector] ) .' {
		box-shadow: 0 0 0 0 '. esc_html( $cynosure_settings[color] ) .';	
		transition: box-shadow 0.3s ease-in-out;
    }
	
	.cynosure-active {
		box-shadow: 0 0 0 max(100vh, 100vw) '. esc_html( $cynosure_settings[color] ) .';			
		transition: box-shadow 0.3s ease-in-out;
		position: relative !important;
		z-index: 99999 !important;
	}		
</style>';
}

add_action('wp_head', 'cynosure_custom_css');

function cynosure_settings_init() {
 	register_setting( 
		'cynosure',
		'cynosure',
		array(
			'type'		=> 'object',
			'default'	=> array( 
				'selector' 		=> '.cynosure',
				'color' 		=> 'rgba(15,20,91,0.7)',
				'debug_mode' 	=> false
				),
			)
 		);
	
	add_option(
		'cynosure',
		array( 
				'selector' 		=> '.cynosure',
				'color' 		=> 'rgba(15,20,91,0.7)',
				'debug_mode' 	=> false
				)
		);

    add_settings_section(
        'cynosure_settings_section',
        'Cynosure Settings',
        'cynosure_settings_section_callback',
        'cynosure'
    );

    add_settings_field(
        'cynosure_selector',
        'CSS Selector',
        'cynosure_selector_field_callback',
        'cynosure',
        'cynosure_settings_section'
    );

    add_settings_field(
        'cynosure_color',
        'Background Color',
        'cynosure_color_field_callback',
        'cynosure',
        'cynosure_settings_section'
    );
	
    add_settings_field(
        'cynosure_debug_mode',
        'Debug Mode',
        'cynosure_debug_mode_callback',
        'cynosure',
        'cynosure_settings_section'
    );
}
add_action('admin_init', 'cynosure_settings_init');

#function cynosure_settings_section_callback() {
    #echo 'Update the settings for the Cynosure plugin.';
#}

function cynosure_selector_field_callback() {
	$cynosure_settings = get_option( 'cynosure' );			
    echo "<input type='text' name='cynosure[selector]' value='" . $cynosure_settings[selector] . "'/>";
	echo "<p class='description'>Enter the <code>.class</code> or <code>#id</code>. We will then make the corresponding <code>&lt;div&gt;</code> the cynosure in your content.</p>";	
}


function cynosure_color_field_callback() {
	$cynosure_settings = get_option( 'cynosure' );		
    #$color = get_option('cynosure_color', 'rgba(0, 0, 0, 0.7)');
    echo "<input type='text' id='cynosure_color' name='cynosure[color]' value='" . $cynosure_settings[color] . "' class='color-picker' data-alpha-enabled='true' />";
    echo "<p class='description'>Choose the background color and opacity for the darkening effect.</p>";
}

function cynosure_debug_mode_callback() {
	$cynosure_settings = get_option( 'cynosure' );	
    if ( $cynosure_settings[debug_mode] ) {
		$debug_checked = " checked";
	}
    echo "<input type='checkbox' id='cynosure_debug_mode' name='cynosure[debug_mode]'" . $debug_checked . "/>";
    echo "<p class='description'>This will output debugging info to the JavaScript console. Please leave unchecked unless troubleshooting.</p>";		
}


function cynosure_options_page() {
    add_options_page(
        'Cynosure Settings',
        'Cynosure',
        'manage_options',
        'cynosure',
        'cynosure_options_page_html'
    );
}

function cynosure_options_page_html() {
    if ( !current_user_can('manage_options' ) ) {
        return;
    }

    settings_errors( 'cynosure_messages' );
    ?>
    <div class="wrap">
        <h1><?= esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'cynosure' );
            do_settings_sections( 'cynosure' );
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

add_action( 'admin_menu', 'cynosure_options_page' );

function cynosure_admin_scripts( $hook ) {
    if ('settings_page_cynosure' != $hook) {
        return;
    }

    wp_enqueue_style('wp-color-picker');
	// Color Picker Alpha: https://github.com/kallookoo/wp-color-picker-alpha
	wp_register_script( 'wp-color-picker-alpha', plugins_url( '/wp-color-picker-alpha.min.js', __FILE__ ), array( 'wp-color-picker' ), $current_version, $in_footer );
	wp_add_inline_script(
		'wp-color-picker-alpha',
		'jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
	);
	wp_enqueue_script( 'wp-color-picker-alpha' );
}

add_action('admin_enqueue_scripts', 'cynosure_admin_scripts');
