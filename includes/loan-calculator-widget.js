// set First Payment Date
// document.getElementById('first-payment-date').value = setFirstPaymentDate();
// Function to calculate APR Interest Equivalent
function rate(nper, pmt, pv, fv = 0, guess = 0.1) {
    const maxIter = 100;
    const tol = 1e-8;
    let r = guess;
  
    for (let i = 0; i < maxIter; i++) {
      const f = pv * Math.pow(1 + r, nper) + pmt * (1 + r * 0) * ( (Math.pow(1 + r, nper) - 1) / r ) + fv;
      const fprime = pv * nper * Math.pow(1 + r, nper - 1) + pmt * ( (Math.pow(1 + r, nper) - 1) / r + nper * Math.pow(1 + r, nper - 1) - ( (Math.pow(1 + r, nper) - 1) / (r * r) ) );
      
      const newR = r - f / fprime;
      if (Math.abs(newR - r) < tol) return newR;
      r = newR;
    }
    return r;
  }

  function rateI(nper, pmt, pv, fv = 0, guess = 1) {
    //loan should due at the beginning of the period

    const maxIter = 100;

    const tol = 1e-8;
    let r = guess;
    for (let i = 0; i < maxIter; i++) {
      const f = pv * Math.pow(1 + r, nper) + pmt * (1 + r) * ( (Math.pow(1 + r, nper) - 1) / r ) + fv;
      const fprime = pv * nper * Math.pow(1 + r, nper - 1) + pmt * ( (Math.pow(1 + r, nper) - 1) / r + nper * Math.pow(1 + r, nper - 1) - ( (Math.pow(1 + r, nper) - 1) / (r * r) ) );
      
      const newR = r - f / fprime;
      if (Math.abs(newR - r) < tol) return newR;
      r = newR;
    }
    return r;
  }
  
function calculateAPRInterestEquivalent(months, interestRate) {
    // Excel formula pmt = (1 + (interestRate * months / 12)) / months
    const pmt = (1 + (interestRate * months / 12)) / months;
    const r = rate(months, pmt, -1); // solve for periodic rate
    return r * 12; // annualized
  }
  

// Function to calculate File fees
function calculateFileFees(loanAmount) {
    // Excel equivalent: =IF(C15<2000,90,150)
    return loanAmount < 2000 ? 90 : 150;
}
// Function to set Approval date to today
function setApprovalDate() {
    const today = new Date();
    const day = today.getDate();
    const month = today.toLocaleString('default', { month: 'short' });
    const year = today.getFullYear().toString().slice(-2); // Get last two digits of the year
    const formattedDate = `${day}-${month}-${year}`; // Format date as DD-MMM-YY
    return formattedDate;
}
// Function to set First Payment Date
    //IF(DAY(approvalDate)<=cutOffMonthlyDay,DATE(YEAR(approvalDate),MONTH(approvalDate)+1,regularPaymentDay),DATE(YEAR(approvalDate),MONTH(approvalDate)+2,regularPaymentDay))

function setFirstPaymentDate(approvalDate, cutOffMonthlyDay, regularPaymentDay) {
    const [day, month, year] = approvalDate.split('-');
    const approvalDateObj = new Date(`20${year}`, new Date(Date.parse(month + " 1, 2000")).getMonth(), day);

    const paymentMonth = approvalDateObj.getDate() <= cutOffMonthlyDay 
        ? approvalDateObj.getMonth() + 1 
        : approvalDateObj.getMonth() + 2;

    const firstPaymentDateObj = new Date(approvalDateObj.getFullYear(), paymentMonth, regularPaymentDay);

    const formattedDate = `${firstPaymentDateObj.getDate()}-${firstPaymentDateObj.toLocaleString('default', { month: 'short' })}-${firstPaymentDateObj.getFullYear().toString().slice(-2)}`;
    return formattedDate;
}
// function to set Interest Accrual Till
function setInterestAccrualTill(firstPaymentDate) {//=DATE(YEAR(firstPaymentDate),MONTH(firstPaymentDate)-1,DAY(firstPaymentDate))
    const [day, month, year] = firstPaymentDate.split('-');
    const firstPaymentDateObj = new Date(`20${year}`, new Date(Date.parse(month + " 1, 2000")).getMonth(), day);
    const interestAccrualTillDateObj = new Date(firstPaymentDateObj.getFullYear(), firstPaymentDateObj.getMonth() - 1, firstPaymentDateObj.getDate());
    const formattedDate = `${interestAccrualTillDateObj.getDate()}-${interestAccrualTillDateObj.toLocaleString('default', { month: 'short' })}-${interestAccrualTillDateObj.getFullYear().toString().slice(-2)}`;
    return formattedDate;
}
// Function to calculate Accrued Interest
function setAccruedInterest(loanAmount, aprInterestEquivalent, interestAccrualTill, approvalDate, AdditionalNbrofValueDays) {//=(loanAmount*aprInterestEquivalent/360*(day of (interestAccrualTill) - day of (approvalDate) + AdditionalNbrofValueDays))
    const [day, month, year] = interestAccrualTill.split('-');
    const [approvalDay, approvalMonth, approvalYear] = approvalDate.split('-');
    const interestAccrualTillDate = new Date(`20${year}`, new Date(Date.parse(month + " 1, 2000")).getMonth(), day);
    const approvalDateObj = new Date(`20${approvalYear}`, new Date(Date.parse(approvalMonth + " 1, 2000")).getMonth(), approvalDay);
    const daysDifference = Math.ceil((interestAccrualTillDate - approvalDateObj) / (1000 * 60 * 60 * 24)) + AdditionalNbrofValueDays; // Calculate days difference
    const accruedInterest = (loanAmount * aprInterestEquivalent / 360) * daysDifference; // Calculate accrued interest
    return accruedInterest.toFixed(2); // Return accrued interest rounded to 2 decimal places
}
// Function to calculate Total loan amount
function setTotalLoanAmount(loanAmount, accruedInterest) {//=totalLoanAmount1+accruedInterest
    return (loanAmount + parseFloat(accruedInterest)).toFixed(2); // Return total loan amount rounded to 2 decimal places
}
// Function to calculate monthly payment excluding PPI
function calculateMonthlyPaymentExclPPI(totalLoanAmount, interestRate, loanTermMonths) {//=(((totalLoanAmount*interestRate*loanTermMonths/12)+totalLoanAmount)/loanTermMonths)
    // Convert totalLoanAmount to decimal
    totalLoanAmount = parseFloat(totalLoanAmount);

    const monthlyPaymentExclPPI = ((totalLoanAmount * interestRate * loanTermMonths / 12) + totalLoanAmount) / loanTermMonths;
    return monthlyPaymentExclPPI.toFixed(2); // Return monthly payment excluding PPI rounded to 2 decimal places
}
// Function to calculate monthly payment
function calculateMonthlyPayment(loanAmount, annualRate, loanTermMonths) {
    const monthlyRate = annualRate / 100 / 12; // Convert annual rate to monthly rate

    // Monthly payment formula
    const monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, loanTermMonths)) / 
                           (Math.pow(1 + monthlyRate, loanTermMonths) - 1);
    return monthlyPayment;
}

// Function to calculate total payment
function calculateTotalPayment(monthlyPayment, loanTermMonths) {
    return monthlyPayment * loanTermMonths;
}

// Function to calculate total interest
function calculateTotalInterest(totalPayment, loanAmount) {
    return totalPayment - loanAmount;
}
// Function to calculate effective APR
function calculateEffectiveAPR(periodMonths, MonthlyPayment, disbursedLoanAmount)  {
    return rateI(periodMonths, -MonthlyPayment, disbursedLoanAmount) * 12*100; // Convert to annual percentage rate

}
function getSelectorElement(id, isPopup) {
    if (isPopup) {
        return document.querySelector(`.elementor-location-popup #${id}`);
    } else {
        return document.getElementById(id);
    }
}
// Event listener for form submission
function calculateLoan(isPopup = false) {
    // prepare the form with default values
    // set approval date to today
    getSelectorElement('approval-date', isPopup).value = setApprovalDate();
    // set first payment date to one month after approval date
    getSelectorElement('first-payment-date', isPopup).value = setFirstPaymentDate(setApprovalDate(), 15, 5); // Assuming cut-off monthly day is 15 and regular payment day is 5
    // set interest accrual till to one month before first payment date
    getSelectorElement('interest-accrual-till', isPopup).value = setInterestAccrualTill(getSelectorElement('first-payment-date', isPopup).value);

    // Get user inputs
    const loanTermMonths = parseInt(getSelectorElement('loan-term', isPopup).value);
    const interestRate = parseFloat(getSelectorElement('interest-rate', isPopup).value) / 100;
    const aprInterestEquivalent = calculateAPRInterestEquivalent(loanTermMonths, interestRate); // Calculate APR Interest Equivalent
    const loanAmount = parseFloat(getSelectorElement('loan-amount', isPopup).value);
    
    const fileFees = calculateFileFees(loanAmount);
    const totalLoanAmount1 = loanAmount + fileFees;
    const stampFees = parseFloat(getSelectorElement('stamp-fees', isPopup).value);
    const disbursedLoanAmount = totalLoanAmount1 - fileFees - stampFees; 
    const approvalDate = setApprovalDate();
    const cutOffMonthlyDay = parseInt(getSelectorElement('cut-off-monthly-day', isPopup).value);
    const regularPaymentDay = parseInt(getSelectorElement('regular-payment-day', isPopup).value);
    const firstPaymentDate = setFirstPaymentDate(approvalDate, cutOffMonthlyDay, regularPaymentDay);
    const interestAccrualTill = setInterestAccrualTill(firstPaymentDate);
    const AdditionalNbrofValueDays = parseInt(getSelectorElement('additional-nbr-of-value-days', isPopup).value);  
    const accruedInterest = setAccruedInterest(totalLoanAmount1, aprInterestEquivalent, interestAccrualTill, approvalDate, AdditionalNbrofValueDays);
    const totalLoanAmount2 = setTotalLoanAmount(totalLoanAmount1, accruedInterest);
    const monthlyPaymentExclPPI = calculateMonthlyPaymentExclPPI(totalLoanAmount2, interestRate, loanTermMonths);
    const ppiCostPerYear = parseFloat(getSelectorElement('ppi-cost-per-year', isPopup).value);
    const ppiCostPercent = (ppiCostPerYear * loanTermMonths / 12).toFixed(6); // Convert to percentage with 6 decimals
    const additionalPPICostPerPayment = (ppiCostPercent / 100 * monthlyPaymentExclPPI).toFixed(4); // Calculate additional PPI cost per payment
    const totalPPICost = (loanTermMonths * additionalPPICostPerPayment).toFixed(2); // Calculate total PPI cost
    const collectionMethod = getSelectorElement('collection-method', isPopup).value;
    const clientsShareCollectionFee = parseFloat(getSelectorElement('clients-share-collection-fee', isPopup).value);
    const totalClientsShareCollectionFees = loanTermMonths * clientsShareCollectionFee; // Calculate total client's share of collection fees
    const monthlyPaymentBeforeRounding = (parseFloat(monthlyPaymentExclPPI) + parseFloat(additionalPPICostPerPayment) + parseFloat(clientsShareCollectionFee)).toFixed(2); // Monthly payment before rounding
    const totalMonthlyPayment = Math.ceil(parseFloat(monthlyPaymentBeforeRounding)); // Total monthly payment
    const effectiveAPR = calculateEffectiveAPR(loanTermMonths, totalMonthlyPayment, disbursedLoanAmount).toFixed(2); // Calculate effective APR and convert to percentage with 2 decimals
    // Change fields at the form
    getSelectorElement('apr-interest-equivalent', isPopup).value = (aprInterestEquivalent * 100).toFixed(2); // Convert to percentage with 2 decimals
    getSelectorElement('file-fees', isPopup).value = fileFees;
    getSelectorElement('total-loan-amount-1', isPopup).value = totalLoanAmount1;
    getSelectorElement('disbursed-loan-amount', isPopup).value = disbursedLoanAmount;
    getSelectorElement('first-payment-date', isPopup).value = firstPaymentDate;
    getSelectorElement('interest-accrual-till', isPopup).value = interestAccrualTill;
    getSelectorElement('accrued-interest', isPopup).value = accruedInterest;
    getSelectorElement('total-loan-amount-2', isPopup).value = totalLoanAmount2;
    getSelectorElement('monthly-payment-excl-ppi', isPopup).value = monthlyPaymentExclPPI;
    getSelectorElement('ppi-cost-percent', isPopup).value = ppiCostPercent;
    getSelectorElement('additional-ppi-cost-per-payment', isPopup).value = additionalPPICostPerPayment;
    getSelectorElement('total-ppi-cost', isPopup).value = totalPPICost;
    getSelectorElement('total-clients-share-collection-fees', isPopup).value = totalClientsShareCollectionFees;
    getSelectorElement('monthly-payment-before-rounding', isPopup).value = monthlyPaymentBeforeRounding;
    getSelectorElement('total-monthly-payment', isPopup).value = totalMonthlyPayment;
    getSelectorElement('effective-apr', isPopup).value = effectiveAPR;

    // add apr to calculation notes
    const aprInNotes = (aprInterestEquivalent * 100).toFixed(2); // Convert to percentage with 2 decimals
    getSelectorElement('calculation-notes', isPopup).innerHTML = `<span>APR rate: ${aprInNotes}%</span>`;
}

// Attach event listener to the button
// document.getElementById('calculate-loan').addEventListener('click', calculateLoan);
// document.querySelectorAll('#loan-calculator-form input, #loan-calculator-form select').forEach(element => {
//     element.addEventListener('change', calculateLoan);
// });
// Function to initialize the loan calculator logic
function initializeLoanCalculator(isPopup = false) {
    // Attach event listener to the button
    const calculateButton = document.getElementById('calculate-loan');
    if (calculateButton) {
        calculateButton.addEventListener('click', () => calculateLoan(isPopup));
    }

    // Attach event listeners to form inputs and selects
    const formElements = document.querySelectorAll('#loan-calculator-form input, #loan-calculator-form select');
    formElements.forEach(element => {
        element.addEventListener('change', () => calculateLoan(isPopup));
    });
}

// Initialize the loan calculator on page load
document.addEventListener('DOMContentLoaded', () => {
    initializeLoanCalculator(false);
});

// Reinitialize the loan calculator when the Elementor popup is opened
jQuery(window).on('elementor/popup/show', () => {
    initializeLoanCalculator(true);
});