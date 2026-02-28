<?php
/**
 * Plugin Name: Peptide Dosing Calculator
 * Description: Frontend shortcode-based peptide reconstitution and dosing calculator.
 * Version: 1.0.0
 * Author: Abdul Basit
 * License: GPL-2.0-or-later
 * Text Domain: peptide-dosing-calculator
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'PDC_VERSION', '1.0.0' );
define( 'PDC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PDC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once PDC_PLUGIN_DIR . 'includes/class-pdc-calculator.php';

function pdc_initialize_plugin() {
    new PDC_Calculator();
}
add_action( 'plugins_loaded', 'pdc_initialize_plugin' );
