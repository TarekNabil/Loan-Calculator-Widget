<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Loan_Calculator_Widget extends \Elementor\Widget_Base {

        use Styling_Controls;
        use Content_Controls;
        use Render_Html;

    public function get_name() {
        return 'loan_calculator';
    }

    public function get_title() {
        return __( 'Loan Calculator', 'loan-calculator-widget' );
    }

    public function get_icon() {
        return "eicon-product-add-to-cart";
    }

    public function get_categories() {
        return [ 'general' ];
    }
    protected function register_controls() {
        // Register content controls
        $this->register_content_controls();

        // Register styling controls
        $this->register_styling_controls();

    }



}