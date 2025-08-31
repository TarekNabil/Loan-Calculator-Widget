<?php
/**
 * Content Controls for Loan Calculator Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

trait Content_Controls {
    protected function register_content_controls() {
        
        $this->start_controls_section(
            'loan_calculator_section',
            [
                'label' => __( 'Defaults', 'loan-calculator-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
            );

            $this->add_control(
                'inputs_title',
                [
                    'label' => __( 'Inputs Title', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( 'Loan Info', 'loan-calculator-widget' ),
                ]
            );

            $this->add_control(
                'outputs_title',
                [
                    'label' => __( 'Outputs Title', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( 'Monthly Payment', 'loan-calculator-widget' ),
                ]
            );
            $this->add_control(
                'loan_amount_placeholder',
                [
                    'label' => __( 'Loan Amount Text', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( 'Enter loan amount', 'loan-calculator-widget' ),
                ]
            );
            //button text
            $this->add_control(
                'calculate_button_text',
                [
                    'label' => __( 'Calculate Button Text', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __( 'Simulate your loan', 'loan-calculator-widget' ),
                ]
            );
            //control separator 
            $this->add_control(
                'separator_1',
                [
                    'type' => \Elementor\Controls_Manager::DIVIDER,
                ]
            );


            $this->add_control(
                'interest_rate',
                [
                    'label' => __( 'Interest Rate (%)', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 14,
                ]
            );

            $this->add_control(
                'loan_term',
                [
                    'label' => __( 'Loan Term (Years)', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 12,
                ]
            );
            $this->add_control(
                'min_loan_term',
                [
                    'label' => __( 'Minimum Loan Term (Months)', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 6,
                ]
            );

            $this->add_control(
                'max_loan_term',
                [
                    'label' => __( 'Maximum Loan Term (Months)', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 24,
                ]
            );


            $this->add_control(
                'file_fees_hint',
                [
                    'label' => __( 'File Fees', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __( 'File Fees are determined based on the loan amount. If the loan amount is less than 2000, the fee is 90. Otherwise, the fee is 150.', 'loan-calculator-widget' ),
                    'content_classes' => 'elementor-descriptor',
                ]
            );
        
            $this->add_control(
                'stamp_fees',
                [
                    'label' => __( 'Stamp Fees', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 0,
                ]
            );
        
            $this->add_control(
                'cut_off_monthly_day',
                [
                    'label' => __( 'Cut Off Monthly Day', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 15,
                ]
            );
        
            $this->add_control(
                'regular_payment_day',
                [
                    'label' => __( 'Regular Payment Day', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 5,
                ]
            );
        
            $this->add_control(
                'additional_nbr_of_value_days',
                [
                    'label' => __( 'Additional Number of Value Days', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 6,
                ]
            );
        
            $this->add_control(
                'ppi_cost_per_year',
                [
                    'label' => __( 'PPI Cost per Year (%)', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 0.18,
                ]
            );
        


        
            $this->add_control(
                'collection_method',
                [
                    'label' => __( 'Collection Method', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'CFC At Counter',
                    'options' => [
                        'FNB Automatic Payment' => __( 'FNB Automatic Payment', 'loan-calculator-widget' ),
                        'CFC At Counter' => __( 'CFC At Counter', 'loan-calculator-widget' ),
                        'Direct Debit' => __( 'Direct Debit', 'loan-calculator-widget' ),
                    ],
                ]
            );
        
            $this->add_control(
                'clients_share_collection_fee',
                [
                    'label' => __( 'Client\'s Share of Collection Fee', 'loan-calculator-widget' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 5.00,
                ]
            );

            
        $this->end_controls_section();
    

    

        $this->start_controls_section(
            'field_visibility_section',
            [
                'label' => __( 'Visibility', 'loan-calculator-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $form_fields = [
            //inputs
            'interest_rate' => __( 'Interest Rate', 'loan-calculator-widget' ),
            'stamp_fees' => __( 'Stamp Fees', 'loan-calculator-widget' ),
            'cut_off_monthly_day' => __( 'Cut Off Monthly Day', 'loan-calculator-widget' ),
            'regular_payment_day' => __( 'Regular Payment Day', 'loan-calculator-widget' ),
            'additional_nbr_of_value_days' => __( 'Additional Number of Value Days', 'loan-calculator-widget' ),
            'ppi_cost_per_year' => __( 'PPI Cost per Year', 'loan-calculator-widget' ),
            'collection_method' => __( 'Collection Method', 'loan-calculator-widget' ),
            'clients_share_collection_fee' => __( 'Client\'s Share of Collection Fee', 'loan-calculator-widget' ),
            //outputs
            'apr_interest_equivalent' => __( 'APR Interest Equivalent', 'loan-calculator-widget' ),
            'file_fees' => __( 'File Fees', 'loan-calculator-widget' ),
            'total_loan_amount_1' => __( 'Total Loan Amount (Calculated)', 'loan-calculator-widget' ),
            
            'disbursed_loan_amount' => __( 'Disbursed Loan Amount', 'loan-calculator-widget' ),
            'approval_date' => __( 'Approval Date', 'loan-calculator-widget' ),
            'first_payment_date' => __( 'First Payment Date', 'loan-calculator-widget' ),
            'interest_accrual_till' => __( 'Interest Accrual Till', 'loan-calculator-widget' ),
            
            'accrued_interest' => __( 'Accrued Interest', 'loan-calculator-widget' ),
            'total_loan_amount_2' => __( 'Total Loan Amount', 'loan-calculator-widget' ),
            'monthly_payment_excl_ppi' => __( 'Monthly Payment Excl. PPI', 'loan-calculator-widget' ),
            
            'ppi_cost_percent' => __( 'PPI Cost in %', 'loan-calculator-widget' ),
            'additional_ppi_cost_per_payment' => __( 'Additional PPI Cost per Payment', 'loan-calculator-widget' ),
            'total_ppi_cost' => __( 'Total PPI Cost', 'loan-calculator-widget' ),
            
            
            'total_clients_share_collection_fees' => __( 'Total Clients\' Share of Collection Fees', 'loan-calculator-widget' ),
            'monthly_payment_before_rounding' => __( 'Monthly Payment Before Rounding', 'loan-calculator-widget' ),
            'total_monthly_payment' => __( 'Total Monthly Payment', 'loan-calculator-widget' ),
            'effective_apr' => __( 'Effective APR', 'loan-calculator-widget' ),
        ];

        foreach ($form_fields as $field_key => $field_label) {
            $this->add_control(
                'show_' . $field_key,
                [
                    'label' => sprintf( __( 'Show %s', 'loan-calculator-widget' ), $field_label ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'loan-calculator-widget' ),
                    'label_off' => __( 'Hide', 'loan-calculator-widget' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );
        }

        $this->end_controls_section();
        
        }

}