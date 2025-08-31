<?php
/**
 * Plugin Name: Loan Calculator Widget
 * Description: Elementor widget to display and calculate a loan calculator.
 * Version: 1.0
 * Author: Tarek Nabil
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once plugin_dir_path( __FILE__ ) . 'includes/styling-controls.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/content-controls.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/render-html.php';

// Register the widget
function register_loan_calculator_widget( $widgets_manager ) {
    require_once( __DIR__ . '/loan-calculator-widget-class.php' );
    $widgets_manager->register( new \Loan_Calculator_Widget() );
}
add_action( 'elementor/widgets/register', 'register_loan_calculator_widget' );

// Enqueue styles and scripts for the Loan Calculator Widget
function loan_calculator_enqueue_assets() {
    // Enqueue the CSS file
    wp_enqueue_style(
        'loan-calculator-style', // Handle
        plugin_dir_url(__FILE__) . '/includes/loan_calculator_style.css', // Path to the CSS file
        [], // Dependencies
        '1.0.0' // Version
    );

    // Enqueue the JavaScript file
    wp_enqueue_script(
        'loan-calculator-widget-script', // Handle
        plugin_dir_url(__FILE__) . '/includes/loan-calculator-widget.js', // Path to the JS file
        ['jquery'], // Dependencies
        '1.0.3', // Version
        true // Load in footer
    );
}
add_action('wp_enqueue_scripts', 'loan_calculator_enqueue_assets');