<?php
/**
 * Styling Controls for Loan Calculator Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

trait Styling_Controls {
    protected function register_styling_controls() {

        $this->start_controls_section(
            'layout_styling_section',
            [
                'label' => __( 'Layout', 'loan-calculator-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //widget background
        $this->add_control(
            'widget_background_color',
            [
                'label' => __( 'Background Color', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#AA0415',
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        //widget padding
        $this->add_control(
            'widget_padding',
            [
                'label' => __( 'Padding', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //widget margins
        $this->add_control(
            'widget_margin',
            [
                'label' => __( 'Margin', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
            );
        //inputs grid columns
        $this->add_responsive_control(
            'inputs_grid_columns_responsive',
            [
            'label' => __( 'Grid Columns', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'range' => [
                'min' => 1,
                'max' => 4,
                'step' => 1,
            ],
            'default' => 2,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'selectors' => [
                '{{WRAPPER}} .inputs-grid, {{WRAPPER}} .outputs-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
            ]
        );

        //grid gap
        $this->add_control(
            'grid_gap',
            [
                'label' => __( 'Grid Gap', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .inputs-grid, {{WRAPPER}} .outputs-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'titles_styling_section',
            [
                'label' => __( 'Titles', 'loan-calculator-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //inputs title color and typography - responsive
        $this->add_control(
            'inputs_title_styling',
            [
                'label' => __( 'Form', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        //titles color
        $this->add_control(
            'inputs_title_color',
            [
                'label' => __( 'Title Color', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget .inputs-title, {{WRAPPER}} .loan-calculator-widget .outputs-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        //titles spaces(margin top and bottom)
        $this->add_control(
            'inputs_title_spacing',
            [
                'label' => __( 'Title Spacing', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget .inputs-title, {{WRAPPER}} .loan-calculator-widget .outputs-title' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // titles typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
            'name' => 'inputs_title_typography',
            'label' => __( 'Title Typography', 'loan-calculator-widget' ),
            'selector' => '{{WRAPPER}} .loan-calculator-widget .inputs-title, {{WRAPPER}} .loan-calculator-widget .outputs-title',
            ]
        );
        //titles line color
        $this->add_control(
            'inputs_title_line_color',
            [
                'label' => __( 'Title Line Color', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#464646',
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget .line-after-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        //titles line height
        $this->add_control(
            'inputs_title_line_height',
            [
            'label' => __( 'Title Line Height', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'step' => 1,
            'default' => 1,
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget .line-after-title' => 'height: {{VALUE}}px;',
            ],
            ]
        );
        //titles line position
        $this->add_control(
            'inputs_title_line_position',
            [
            'label' => __( 'Title Line Position', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [
                'em' => [
                'min' => -10,
                'max' => 10,
                'step' => 1,
                ],
            ],
            'default' => [
                'size' => 40,
            ],
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget .line-after-title' => 'transform: translateY(calc({{SIZE}}em / 100));',
            ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'form_styling_section',
            [
                'label' => __( 'Form', 'loan-calculator-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        //
        // Description styling
        $this->add_control(
            'description_styling',
            [
                'label' => __( 'Description', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        //description text color
        $this->add_control(
            'description_text_color',
            [
                'label' => __( 'Color', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget .description' => 'color: {{VALUE}};',
                ],
            ]
        );
        //description font attributes
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __( 'Typography', 'loan-calculator-widget' ),
                'selector' => '{{WRAPPER}} .loan-calculator-widget .description',
            ]
        );
        //description spacing
        $this->add_control(
            'description_spacing',
            [
                'label' => __( 'Spacing', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget .description' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // form fields styling
        $this->add_control(
            'form_fields_styling',
            [
                'label' => __( 'Input', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        // form fields typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'form_fields_typography',
                'label' => __( 'Typography', 'loan-calculator-widget' ),
                'selector' => '{{WRAPPER}} .loan-calculator-widget input, {{WRAPPER}} .loan-calculator-widget select',
            ]
        );

        $this->add_control(
            'form_fields_text_color',
            [
                'label' => __( 'Color', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff0000',
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget input, {{WRAPPER}} .loan-calculator-widget select, {{WRAPPER}} .loan-calculator-widget input::placeholder, {{WRAPPER}} .loan-calculator-widget select::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_fields_background_color',
            [
                'label' => __( 'Background Color', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget input, {{WRAPPER}} .loan-calculator-widget select' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        // input width
        $this->add_control(
            'form_fields_width',
            [
                'label' => __( 'Width', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px', 'em' ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 5,
                        'max' => 50,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget input, {{WRAPPER}} .loan-calculator-widget select' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'form_fields_border_styling',
            [
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            ]
        );

        $this->add_control(
            'form_fields_border_color',
            [
                'label' => __( 'Border Color', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget input, {{WRAPPER}} .loan-calculator-widget select' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_fields_border_width',
            [
                'label' => __( 'Border Width', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget input, {{WRAPPER}} .loan-calculator-widget select' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'form_fields_border_radius',
            [
                'label' => __( 'Border Radius', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget input, {{WRAPPER}} .loan-calculator-widget select' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'form_fields_padding',
            [
                'label' => __( 'Padding', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 5,
                    'right' => 5,
                    'bottom' => 5,
                    'left' => 5,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget input, {{WRAPPER}} .loan-calculator-widget select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'buttom_styling_section',
            [
                'label' => __( 'Button', 'loan-calculator-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //button alignment
        $this->add_control(
            'button_position',
            [
            'label' => __( 'Alignment', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                'title' => __( 'Left', 'loan-calculator-widget' ),
                'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                'title' => __( 'Center', 'loan-calculator-widget' ),
                'icon' => 'eicon-h-align-center',
                ],
                'flex-end' => [
                'title' => __( 'Right', 'loan-calculator-widget' ),
                'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget .calculate-button-wrapper' => 'align-items: {{VALUE}};',
            ],
            ]
        );
        
        //button width
        $this->add_control(
            'button_width',
            [
            'label' => __( 'Width', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ '%', 'px', 'em' ],
            'range' => [
                '%' => [
                'min' => 10,
                'max' => 100,
                'step' => 1,
                ],
                'px' => [
                'min' => 50,
                'max' => 500,
                'step' => 1,
                ],
                'em' => [
                'min' => 5,
                'max' => 50,
                'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 100,
            ],
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button' => 'width: {{SIZE}}{{UNIT}};',
            ],
            ]
        );
        
        // Button typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
            'name' => 'button_typography',
            'label' => __( 'Typography', 'loan-calculator-widget' ),
            'selector' => '{{WRAPPER}} .loan-calculator-widget button',
            ]
        );


        // Button styling (Normal and Hover states)
        $this->start_controls_tabs('button_style_tabs');

        // Normal state
        $this->start_controls_tab(
            'button_normal_tab',
            [
            'label' => __( 'Normal', 'loan-calculator-widget' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
            'label' => __( 'Text Color', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button' => 'color: {{VALUE}};',
            ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
            'label' => __( 'Background Color', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FF6700',
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button' => 'background-color: {{VALUE}};',
            ],
            ]
        );

        $this->add_control(
            'button_border_color',
            [
            'label' => __( 'Border Color', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FF6700',
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button' => 'border-color: {{VALUE}};',
            ],
            ]
        );

        $this->end_controls_tab();

        // Hover state
        $this->start_controls_tab(
            'button_hover_tab',
            [
            'label' => __( 'Hover', 'loan-calculator-widget' ),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
            'label' => __( 'Text Color', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button:hover' => 'color: {{VALUE}};',
            ],
            ]
        );
        //add

        $this->add_control(
            'button_hover_background_color',
            [
            'label' => __( 'Background Color', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#DF5900',
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button:hover' => 'background-color: {{VALUE}};',
            ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
            'label' => __( 'Border Color', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#DF5900',
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button:hover' => 'border-color: {{VALUE}};',
            ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        //add separator
        $this->add_control(
            'button_border_styling',
            [
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            ]
        );


        // Button border width
        $this->add_control(
            'button_border_width',
            [
            'label' => __( 'Border Width', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                'min' => 0,
                'max' => 10,
                'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 0,
            ],
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button' => 'border-width: {{SIZE}}{{UNIT}};',
            ],
            ]
        );

        // Button border radius
        $this->add_control(
            'button_border_radius',
            [
            'label' => __( 'Border Radius', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range' => [
                'px' => [
                'min' => 0,
                'max' => 50,
                'step' => 1,
                ],
                '%' => [
                'min' => 0,
                'max' => 50,
                'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 5,
            ],
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
            ]
        );

        // Button padding
        $this->add_control(
            'button_padding',
            [
            'label' => __( 'Padding', 'loan-calculator-widget' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default' => [
                'top' => 10,
                'right' => 20,
                'bottom' => 10,
                'left' => 20,
                'unit' => 'px',
                'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .loan-calculator-widget button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            ]
        );
        $this->end_controls_section();

        //calculation notes
        $this->start_controls_section(
            'calculation_notes_styling_section',
            [
                'label' => __( 'Calculation Notes', 'loan-calculator-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //calculation notes text color
        $this->add_control(
            'calculation_notes_text_color',
            [
                'label' => __( 'Color', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget .calculation-notes' => 'color: {{VALUE}};',
                ],
            ]
        );
        //calculation notes font attributes
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'calculation_notes_typography',
                'label' => __( 'Typography', 'loan-calculator-widget' ),
                'selector' => '{{WRAPPER}} .loan-calculator-widget .calculation-notes',
            ]
        );
        //calculation notes spacing
        $this->add_control(
            'calculation_notes_spacing',
            [
                'label' => __( 'Spacing', 'loan-calculator-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .loan-calculator-widget .calculation-notes' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        


        $this->end_controls_section();
        

    }
}