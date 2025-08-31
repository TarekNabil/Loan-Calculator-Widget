<?php
/**
 * Trait for rendering the Loan Calculator Widget.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

trait Render_Html {

    protected function render() {
        $settings = $this->get_settings_for_display();
        $interest_rate = $settings['interest_rate'] / 100 ;
    
    // Add HTML for interactive inputs
    echo '<div class="loan-calculator-widget">';
    //inputs------------------------------------------

    $inputs_title_class = (!empty($settings['show_inputs_title']) && $settings['show_inputs_title'] === 'yes') ? '' : 'hidden';
    echo '<div class="inputs-title-wrapper" >';
    echo '<h4 class="inputs-title ' . esc_attr($inputs_title_class) . '" >' . esc_html($settings['inputs_title']) . '</h4>';
    echo '<span class="line-after-title" ></span>';
    echo '</div>';
    echo '<form id="loan-calculator-form">';
    
    echo '<div class="inputs-grid" style="display: grid; ">';
    
    echo '<div class="form-group ">
            <input type="number" id="loan-amount" placeholder="' . esc_attr($settings['loan_amount_placeholder']) . '" />
          </div>';
    //loan term
    
    echo '<div class="form-group ">
            <select id="loan-term">';
    for ($i = $settings['min_loan_term']; $i <= $settings['max_loan_term']; $i++) {
        $is_selected = ($i == $settings['loan_term']) ? 'selected' : '';
        echo '<option value="' . esc_attr($i) . '" ' . $is_selected . '>' . esc_html($i) . ' months</option>';
    }
    echo '</select>
            <p class="description">Enter a value between ' . esc_html($settings['min_loan_term']) . ' and ' . esc_html($settings['max_loan_term']) . ' months.</p>
          </div>';
    //interest rate
    $interest_rate_class = (!empty($settings['show_interest_rate']) && $settings['show_interest_rate'] === 'yes') ? '' : 'hidden';
    echo '<div class="form-group ' . esc_attr($interest_rate_class) . '">
            <input type="number" id="interest-rate" value="' . esc_attr($settings['interest_rate']) . '" />
            <p class="description">Interest Rate (%)</p>
          </div>';
        $stamp_fees_class = (!empty($settings['show_stamp_fees']) && $settings['show_stamp_fees'] === 'yes') ? '' : 'hidden';
        echo '<div class="form-group ' . esc_attr($stamp_fees_class) . '">
                <input type="number" id="stamp-fees" value="' . esc_attr($settings['stamp_fees']) . '" readonly/>
                <p class="description">Stamp Fees</p>
        </div>';
    $cut_off_monthly_day_class = (!empty($settings['show_cut_off_monthly_day']) && $settings['show_cut_off_monthly_day'] === 'yes') ? '' : 'hidden';
    echo '<div class="form-group ' . esc_attr($cut_off_monthly_day_class) . '">
            <input type="number" id="cut-off-monthly-day" value="' . esc_attr($settings['cut_off_monthly_day']) . '" min="1" max="30" />
            <p class="description">Cut Off Monthly Day</p>
        </div>';
    $regular_payment_day_class = (!empty($settings['show_regular_payment_day']) && $settings['show_regular_payment_day'] === 'yes') ? '' : 'hidden';
    echo '<div class="form-group ' . esc_attr($regular_payment_day_class) . '">
            <input type="number" id="regular-payment-day" value="' . esc_attr($settings['regular_payment_day']) . '" min="1" max="30" />
            <p class="description">Regular Payment Day</p>
        </div>';
        $additional_nbr_of_value_days_class = (!empty($settings['show_additional_nbr_of_value_days']) && $settings['show_additional_nbr_of_value_days'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($additional_nbr_of_value_days_class) . '">
                <input type="number" id="additional-nbr-of-value-days" value="' . esc_attr($settings['additional_nbr_of_value_days']) . '" min="0" max="30" />
                <p class="description">Additional Number of Value Days</p>
                </div>';
        $ppi_cost_per_year_class = (!empty($settings['show_ppi_cost_per_year']) && $settings['show_ppi_cost_per_year'] === 'yes') ? '' : 'hidden';
        echo '<div class="form-group ' . esc_attr($ppi_cost_per_year_class) . '">
                        <input type="number" id="ppi-cost-per-year" value="' . esc_attr($settings['ppi_cost_per_year']) . '" />
                        <p class="description">PPI Cost per Year (%)</p>
                        </div>';
        $collection_method_class = (!empty($settings['show_collection_method']) && $settings['show_collection_method'] === 'yes') ? '' : 'hidden';
        echo '<div class="form-group ' . esc_attr($collection_method_class) . '">
                        <select id="collection-method">
                                <option value="FNB Automatic Payment" ' . selected($settings['collection_method'], 'FNB Automatic Payment', false) . '>FNB Automatic Payment</option>
                                <option value="CFC At Counter" ' . selected($settings['collection_method'], 'CFC At Counter', false) . '>CFC At Counter</option>
                                <option value="Direct Debit" ' . selected($settings['collection_method'], 'Direct Debit', false) . '>Direct Debit</option>
                        </select>
                        <p class="description">Collection Method</p>
                        </div>';
        $clients_share_collection_fee_class = (!empty($settings['show_clients_share_collection_fee']) && $settings['show_clients_share_collection_fee'] === 'yes') ? '' : 'hidden';
        echo '<div class="form-group ' . esc_attr($clients_share_collection_fee_class) . '">
                        <input type="number" id="clients-share-collection-fee" value="' . esc_attr($settings['clients_share_collection_fee']) . '" />
                        <p class="description">Client\'s Share of Collection Fee Per Promissory Note</p>
                        </div>';
    // Wrap inputs into a grid container
    echo '</div>'; // Close form-grid
    //outputs------------------------------------------

    $outputs_title_class = (!empty($settings['show_outputs_title']) && $settings['show_outputs_title'] === 'yes') ? '' : 'hidden';
    echo '<div class="outputs-title-wrapper">';
    echo '<h4 class="outputs-title ' . esc_attr($outputs_title_class) . '">' . esc_html($settings['outputs_title']) . '</h4>';
    echo '<span class="line-after-title"></span>';
    echo '</div>';
    echo '<div class="outputs-grid" style="display: grid; ">';

    //apr interest equivalent
    $apr_interest_equivalent_class = (!empty($settings['show_apr_interest_equivalent']) && $settings['show_apr_interest_equivalent'] === 'yes') ? '' : 'hidden';
    echo '<div class="form-group ' . esc_attr($apr_interest_equivalent_class) . '">
        <input type="number" id="apr-interest-equivalent" value="" readonly/>
        <p class="description">APR Interest Equivalent (%)</p>
        </div>';    
    $file_fees_class = (!empty($settings['show_file_fees']) && $settings['show_file_fees'] === 'yes') ? '' : 'hidden';
    echo '<div class="form-group ' . esc_attr($file_fees_class) . '">
            <input type="number" id="file-fees" value="" readonly />
            <p class="description">File Fees</p>
          </div>';
    $total_loan_amount_1_class = (!empty($settings['show_total_loan_amount_1']) && $settings['show_total_loan_amount_1'] === 'yes') ? '' : 'hidden';
    echo '<div class="form-group ' . esc_attr($total_loan_amount_1_class) . '">
        <input type="number" id="total-loan-amount-1" value="" readonly />
        <p class="description">Total Loan Amount (Calculated)</p>
          </div>';
    
    $disbursed_loan_amount_class = (!empty($settings['show_disbursed_loan_amount']) && $settings['show_disbursed_loan_amount'] === 'yes') ? '' : 'hidden';
    echo '<div class="form-group ' . esc_attr($disbursed_loan_amount_class) . '">
        <input type="number" id="disbursed-loan-amount" value="" readonly />
        <p class="description">Disbursed Loan Amount</p>
          </div>';
    // Approval Date
    $approval_date_class = (!empty($settings['show_approval_date']) && $settings['show_approval_date'] === 'yes') ? '' : 'hidden';
    echo '<div class="form-group ' . esc_attr($approval_date_class) . '">
        <input type="text" id="approval-date" value="" readonly />
        <p class="description">Approval Date</p>
          </div>';

        $first_payment_date_class = (!empty($settings['show_first_payment_date']) && $settings['show_first_payment_date'] === 'yes') ? '' : 'hidden';
        echo '<div class="form-group ' . esc_attr($first_payment_date_class) . '">
                <input type="text" id="first-payment-date" value="" readonly />
                <p class="description">First Payment Date</p>
                </div>';

$interest_accrual_till_class = (!empty($settings['show_interest_accrual_till']) && $settings['show_interest_accrual_till'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($interest_accrual_till_class) . '">
                <input type="text" id="interest-accrual-till" value="" readonly />
                <p class="description">Interest Accrual Till</p>
                </div>';



$accrued_interest_class = (!empty($settings['show_accrued_interest']) && $settings['show_accrued_interest'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($accrued_interest_class) . '">
                <input type="number" id="accrued-interest" value="" readonly />
                <p class="description">Accrued Interest</p>
                </div>';

$total_loan_amount_2_class = (!empty($settings['show_total_loan_amount_2']) && $settings['show_total_loan_amount_2'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($total_loan_amount_2_class) . '">
                <input type="text" id="total-loan-amount-2" value="" readonly />
                <p class="description">Total Loan Amount</p>
                </div>';

$monthly_payment_excl_ppi_class = (!empty($settings['show_monthly_payment_excl_ppi']) && $settings['show_monthly_payment_excl_ppi'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($monthly_payment_excl_ppi_class) . '">
                <input type="number" id="monthly-payment-excl-ppi" value="" readonly />
                <p class="description">Monthly Payment Excl. Payment Protection Insurance (PPI)</p>
                </div>';



$ppi_cost_percent_class = (!empty($settings['show_ppi_cost_percent']) && $settings['show_ppi_cost_percent'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($ppi_cost_percent_class) . '">
                <input type="number" id="ppi-cost-percent" value="" readonly />
                <p class="description">Payment Protection Insurance (PPI) Cost in %</p>
                </div>';

$additional_ppi_cost_per_payment_class = (!empty($settings['show_additional_ppi_cost_per_payment']) && $settings['show_additional_ppi_cost_per_payment'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($additional_ppi_cost_per_payment_class) . '">
                <input type="number" id="additional-ppi-cost-per-payment" value="" readonly />
                <p class="description">Additional PPI Cost per Payment</p>
                </div>';

$total_ppi_cost_class = (!empty($settings['show_total_ppi_cost']) && $settings['show_total_ppi_cost'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($total_ppi_cost_class) . '">
                <input type="number" id="total-ppi-cost" value="" readonly />
                <p class="description">Total PPI Cost</p>
                </div>';





$total_clients_share_collection_fees_class = (!empty($settings['show_total_clients_share_collection_fees']) && $settings['show_total_clients_share_collection_fees'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($total_clients_share_collection_fees_class) . '">
                <input type="number" id="total-clients-share-collection-fees" value="" readonly />
                <p class="description">Total Clients\' Share of Collection Fees</p>
                </div>';

$monthly_payment_before_rounding_class = (!empty($settings['show_monthly_payment_before_rounding']) && $settings['show_monthly_payment_before_rounding'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($monthly_payment_before_rounding_class) . '">
                <input type="number" id="monthly-payment-before-rounding" value="" readonly />
                <p class="description">Monthly Payment Bef. Rounding</p>
                </div>';

$total_monthly_payment_class = (!empty($settings['show_total_monthly_payment']) && $settings['show_total_monthly_payment'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($total_monthly_payment_class) . '">
                <input type="number" id="total-monthly-payment" value="" readonly />
                <p class="description">Total Monthly Payment</p>
                </div>';

$effective_apr_class = (!empty($settings['show_effective_apr']) && $settings['show_effective_apr'] === 'yes') ? '' : 'hidden';
echo '<div class="form-group ' . esc_attr($effective_apr_class) . '">
                <input type="number" id="effective-apr" value="" readonly />
                <p class="description">Effective APR (inclusive PPI+Collection Fees+File Fees+Stamp Fees)</p>
                </div>';
    echo '<div class="form-group calculate-button-wrapper">';
        $button_text = !empty($settings['calculate_button_text']) ? $settings['calculate_button_text'] : 'Calculate';
        echo '<button type="button" id="calculate-loan">' . esc_html($button_text) . '</button>';
        echo '<span id="calculation-notes" class="calculation-notes"></span>';
        echo '</div>'; // Close calculate-button-wrapper

    echo '</div>'; // Close outputs-grid

    echo '</form>';
    echo '</div>';

    echo '<div class="loan-result-wrapper">Monthly Payment: $<span id="loan-result"></span></div>';
    echo '</div>';


    }
}