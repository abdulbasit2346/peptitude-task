<?php

// Prevent direct access to the file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main Calculator Class
 *
 * Handles:
 * - Shortcode registration
 * - Asset enqueuing
 * - Frontend calculator rendering
 */
class PDC_Calculator {

    /**
     * Constructor
     * Hooks shortcode and asset loading.
     */
    public function __construct() {

        // Register shortcode
        add_shortcode( 'peptide_dosing_calculator', array( $this, 'render_calculator' ) );

        // Enqueue frontend assets
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    /**
     * Enqueue Plugin CSS & JS Files
     *
     * Loads:
     * - Main stylesheet
     * - Frontend calculation script (in footer)
     */
    public function enqueue_assets() {

        wp_enqueue_style(
            'pdc-style',
            PDC_PLUGIN_URL . 'assets/css/pdc-style.css',
            array(),
            PDC_VERSION
        );

        wp_enqueue_script(
            'pdc-script',
            PDC_PLUGIN_URL . 'assets/js/pdc-script.js',
            array(),
            PDC_VERSION,
            true
        );
    }

    /**
     * Render Calculator Shortcode Output
     *
     * Generates:
     * - Disclaimer
     * - Input form
     * - Results section
     *
     * @return string HTML output
     */
    public function render_calculator() {

        ob_start();
        ?>
        <div class="pdc-wrapper">

            <!-- ===================================== -->
            <!-- EDUCATIONAL DISCLAIMER SECTION -->
            <!-- ===================================== -->
            <div class="pdc-disclaimer">
                <strong>
                    <?php esc_html_e(
                        'This is an EDUCATIONAL / RESEARCH tool only. NOT medical advice. Peptide use carries serious risks. Always consult a qualified healthcare professional.',
                        'peptide-dosing-calculator'
                    ); ?>
                </strong>
            </div>

            <!-- ===================================== -->
            <!-- CALCULATOR INPUT FORM -->
            <!-- ===================================== -->
            <form id="pdc-form">

                <!-- Peptide Vial Amount -->
                <label for="pdc-vial">
                    <?php esc_html_e( 'Peptide Vial Amount (mg)', 'peptide-dosing-calculator' ); ?>
                </label>
                <select id="pdc-vial">
                    <option value="5"><?php esc_html_e( '5 mg', 'peptide-dosing-calculator' ); ?></option>
                    <option value="10" selected><?php esc_html_e( '10 mg', 'peptide-dosing-calculator' ); ?></option>
                    <option value="15"><?php esc_html_e( '15 mg', 'peptide-dosing-calculator' ); ?></option>
                    <option value="custom"><?php esc_html_e( 'Custom', 'peptide-dosing-calculator' ); ?></option>
                </select>
                <input 
                    type="number" 
                    id="pdc-vial-custom" 
                    placeholder="<?php echo esc_attr__( 'Enter mg', 'peptide-dosing-calculator' ); ?>" 
                    hidden
                >

                <!-- Water Volume -->
                <label for="pdc-water">
                    <?php esc_html_e( 'Bacteriostatic Water (mL)', 'peptide-dosing-calculator' ); ?>
                </label>
                <select id="pdc-water">
                    <option value="1"><?php esc_html_e( '1 mL', 'peptide-dosing-calculator' ); ?></option>
                    <option value="2" selected><?php esc_html_e( '2 mL', 'peptide-dosing-calculator' ); ?></option>
                    <option value="3"><?php esc_html_e( '3 mL', 'peptide-dosing-calculator' ); ?></option>
                    <option value="custom"><?php esc_html_e( 'Custom', 'peptide-dosing-calculator' ); ?></option>
                </select>
                <input 
                    type="number" 
                    id="pdc-water-custom" 
                    placeholder="<?php echo esc_attr__( 'Enter mL', 'peptide-dosing-calculator' ); ?>" 
                    hidden
                >

                <!-- Desired Dose -->
                <label for="pdc-dose">
                    <?php esc_html_e( 'Desired Dose (mcg)', 'peptide-dosing-calculator' ); ?>
                </label>
                <select id="pdc-dose">
                    <option value="250"><?php esc_html_e( '250 mcg', 'peptide-dosing-calculator' ); ?></option>
                    <option value="500" selected><?php esc_html_e( '500 mcg', 'peptide-dosing-calculator' ); ?></option>
                    <option value="1000"><?php esc_html_e( '1000 mcg', 'peptide-dosing-calculator' ); ?></option>
                    <option value="custom"><?php esc_html_e( 'Custom', 'peptide-dosing-calculator' ); ?></option>
                </select>
                <input 
                    type="number" 
                    id="pdc-dose-custom" 
                    placeholder="<?php echo esc_attr__( 'Enter mcg', 'peptide-dosing-calculator' ); ?>" 
                    hidden
                >

                <!-- Syringe Type -->
                <label for="pdc-syringe">
                    <?php esc_html_e( 'Syringe Type (U-100)', 'peptide-dosing-calculator' ); ?>
                </label>
                <select id="pdc-syringe">
                    <option value="30"><?php esc_html_e( '0.3 mL / 30 units', 'peptide-dosing-calculator' ); ?></option>
                    <option value="50"><?php esc_html_e( '0.5 mL / 50 units', 'peptide-dosing-calculator' ); ?></option>
                    <option value="100" selected><?php esc_html_e( '1 mL / 100 units', 'peptide-dosing-calculator' ); ?></option>
                </select>

                <!-- Validation Error Message -->
                <div id="pdc-error" class="pdc-error"></div>

            </form>

            <!-- ===================================== -->
            <!-- RESULTS DISPLAY SECTION -->
            <!-- Hidden until calculation is performed -->
            <!-- ===================================== -->
            <div id="pdc-results" class="pdc-results" hidden>

                <p class="result-head">
                    <strong><?php esc_html_e( 'RESULTS', 'peptide-dosing-calculator' ); ?></strong>
                </p>

                <p>
                    <strong><?php esc_html_e( 'Concentration:', 'peptide-dosing-calculator' ); ?></strong>
                    <span id="pdc-concentration"></span> mcg/mL
                </p>

                <p>
                    <strong><?php esc_html_e( 'Volume per Dose:', 'peptide-dosing-calculator' ); ?></strong>
                    <span id="pdc-volume"></span> mL
                </p>

                <p>
                    <strong><?php esc_html_e( 'Units to Draw:', 'peptide-dosing-calculator' ); ?></strong>
                    <span id="pdc-units"></span> units
                </p>

                <p>
                    <strong><?php esc_html_e( 'Doses per Vial:', 'peptide-dosing-calculator' ); ?></strong>
                    <span id="pdc-doses"></span>
                </p>

                <!-- Syringe Capacity Visual Indicator -->
                <div class="pdc-bar-container">
                    <div id="pdc-bar" class="pdc-bar"></div>
                </div>

                <!-- Capacity Warning Message -->
                <div id="pdc-warning" class="pdc-warning"></div>

            </div>

        </div>
        <?php
        return ob_get_clean();
    }
}