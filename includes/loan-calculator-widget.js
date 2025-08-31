// prepare the form with default values
//set approval date to today
document.getElementById('approval-date').value = setApprovalDate();
// set first payment date to one month after approval date
document.getElementById('first-payment-date').value = setFirstPaymentDate(setApprovalDate(), 15, 5); // Assuming cut-off monthly day is 15 and regular payment day is 5
// set interest accrual till to one month before first payment date
document.getElementById('interest-accrual-till').value = setInterestAccrualTill(document.getElementById('first-payment-date').value);
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
    // console.log(`Calculated periodic rate: ${r}`);
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

// Event listener for form submission
function calculateLoan() {
    // Get user inputs
    const loanTermMonths = parseInt(document.getElementById('loan-term').value);
    console.log(`Loan Term (Months): ${loanTermMonths}`);
    const interestRate = parseFloat(document.getElementById('interest-rate').value) / 100;
    // const aprInterestEquivalent = parseFloat(document.getElementById('apr-interest-equivalent').value) / 100; // Convert to decimal
    const aprInterestEquivalent = calculateAPRInterestEquivalent(loanTermMonths, interestRate); // Calculate APR Interest Equivalent
    const loanAmount = parseFloat(document.getElementById('loan-amount').value);
    const fileFees = calculateFileFees(loanAmount);
    const totalLoanAmount1 = loanAmount + fileFees;
    const stampFees = parseFloat(document.getElementById('stamp-fees').value);
    const disbursedLoanAmount = totalLoanAmount1 - fileFees - stampFees; 
    const approvalDate = setApprovalDate();
    const cutOffMonthlyDay = parseInt(document.getElementById('cut-off-monthly-day').value);
    const regularPaymentDay = parseInt(document.getElementById('regular-payment-day').value);
    const firstPaymentDate = setFirstPaymentDate(approvalDate, cutOffMonthlyDay, regularPaymentDay);
    const interestAccrualTill = setInterestAccrualTill(firstPaymentDate);
    const AdditionalNbrofValueDays = parseInt(document.getElementById('additional-nbr-of-value-days').value);  
    const accruedInterest = setAccruedInterest(totalLoanAmount1, aprInterestEquivalent, interestAccrualTill, approvalDate, AdditionalNbrofValueDays);
    const totalLoanAmount2 = setTotalLoanAmount(totalLoanAmount1, accruedInterest);
    const monthlyPaymentExclPPI = calculateMonthlyPaymentExclPPI(totalLoanAmount2, interestRate, loanTermMonths);
    const ppiCostPerYear = parseFloat(document.getElementById('ppi-cost-per-year').value);
    const ppiCostPercent = (ppiCostPerYear * loanTermMonths / 12).toFixed(6); // Convert to percentage with 6 decimals
    const additionalPPICostPerPayment = (ppiCostPercent / 100 * monthlyPaymentExclPPI).toFixed(4); // Calculate additional PPI cost per payment
    const totalPPICost = (loanTermMonths * additionalPPICostPerPayment).toFixed(2); // Calculate total PPI cost
    const collectionMethod = document.getElementById('collection-method').value;
    const clientsShareCollectionFee = parseFloat(document.getElementById('clients-share-collection-fee').value);
    const totalClientsShareCollectionFees = loanTermMonths * clientsShareCollectionFee; // Calculate total client's share of collection fees
    const monthlyPaymentBeforeRounding = (parseFloat(monthlyPaymentExclPPI) + parseFloat(additionalPPICostPerPayment) + parseFloat(clientsShareCollectionFee)).toFixed(2); // Monthly payment before rounding
    console.log(`Monthly Payment Before Rounding: ${monthlyPaymentBeforeRounding}`);
    const totalMonthlyPayment = Math.ceil(parseFloat(monthlyPaymentBeforeRounding)); // Total monthly payment
    const effectiveAPR = calculateEffectiveAPR(loanTermMonths, totalMonthlyPayment, disbursedLoanAmount).toFixed(2); // Calculate effective APR and convert to percentage with 2 decimals
    console.log('we will add the table now');
    // Change fields at the form
    document.getElementById('apr-interest-equivalent').value = (aprInterestEquivalent * 100).toFixed(2); // Convert to percentage with 2 decimals
    document.getElementById('file-fees').value = fileFees;
    document.getElementById('total-loan-amount-1').value = totalLoanAmount1;
    document.getElementById('disbursed-loan-amount').value = disbursedLoanAmount;
    document.getElementById('first-payment-date').value = firstPaymentDate;
    document.getElementById('interest-accrual-till').value = interestAccrualTill;
    document.getElementById('accrued-interest').value = accruedInterest;
    document.getElementById('total-loan-amount-2').value = totalLoanAmount2;
    document.getElementById('monthly-payment-excl-ppi').value = monthlyPaymentExclPPI;
    document.getElementById('ppi-cost-percent').value = ppiCostPercent;
    document.getElementById('additional-ppi-cost-per-payment').value = additionalPPICostPerPayment;
    document.getElementById('total-ppi-cost').value = totalPPICost;
    document.getElementById('total-clients-share-collection-fees').value = totalClientsShareCollectionFees;
    document.getElementById('monthly-payment-before-rounding').value = monthlyPaymentBeforeRounding;
    document.getElementById('total-monthly-payment').value = totalMonthlyPayment;
    document.getElementById('effective-apr').value = effectiveAPR;

    // add effective-apr to calculation notes
    document.getElementById('calculation-notes').innerHTML = `<span>APR rate: ${effectiveAPR}%</span>`;
    

    // Display results
    var html = `
        <table border="1">
        <tr>
                <th colspan="3"><h2>Schedule</h2></th>
            </tr>
        <tr>
            <th>Payment No.</th>
            <th>Payment Date</th>
            <th>Payment</th>
        </tr>
    `;
    let balance = totalLoanAmount2;
    let [day, month, year] = firstPaymentDate.split('-');
    let paymentDate = new Date(`20${year}`, new Date(Date.parse(month + " 1, 2000")).getMonth(), day);

    for (let i = 1; i <= loanTermMonths; i++) {
        const interestPayment = (balance * interestRate / 12).toFixed(2);
        const principalPayment = (totalMonthlyPayment - interestPayment).toFixed(2);
        balance = (balance - principalPayment).toFixed(2);

        const formattedDate = `${paymentDate.getDate()}-${paymentDate.toLocaleString('default', { month: 'short' })}-${paymentDate.getFullYear().toString().slice(-2)}`;
        html += `
            <tr>
                <td>${i}</td>
                <td>${formattedDate}</td>
                <td>${totalMonthlyPayment}</td>
            </tr>
        `;

        paymentDate.setMonth(paymentDate.getMonth() + 1); // Move to the next month
    }
    html += `</table>`;
    const totalOfTotalPayments = (totalMonthlyPayment * loanTermMonths).toFixed(2);
    html += `<p><strong>Total Payments:</strong> ${totalOfTotalPayments}</p>`;
    document.getElementById('loan-result').innerHTML = html;
}

// Attach event listener to the button
document.getElementById('calculate-loan').addEventListener('click', calculateLoan);
document.querySelectorAll('#loan-calculator-form input, #loan-calculator-form select').forEach(element => {
    element.addEventListener('change', calculateLoan);
});
// Call calculateLoan when the page loads
// document.addEventListener('DOMContentLoaded', calculateLoan);