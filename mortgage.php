<?php include 'header.php'; ?>

    <!-- Page-specific styles for enhanced mortgage calculator -->
    <style>
        .input-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 2px solid #e9ecef;
        }

        .input-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
            align-items: end;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        .input-group input, .input-group select {
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 500;
            background: white;
            transition: all 0.3s ease;
        }

        .input-group input:focus, .input-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .currency-input {
            position: relative;
        }

        .currency-input::before {
            content: "€";
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            font-weight: bold;
            color: #666;
            z-index: 1;
        }

        .currency-input input {
            padding-left: 35px;
        }

        .ltv-display {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }

        .ltv-percentage {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .ltv-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .quick-amounts {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .quick-btn {
            background: #e9ecef;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .quick-btn:hover {
            background: #667eea;
            color: white;
        }

        .best-deal-banner {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
        }

        .best-deal-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .best-deal-details {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .results-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .result-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 5px solid #ddd;
            transition: transform 0.3s ease;
            position: relative;
        }

        .result-card:hover {
            transform: translateY(-5px);
        }

        .result-card.best-rate {
            border-left-color: #28a745;
            box-shadow: 0 15px 40px rgba(40, 167, 69, 0.2);
        }

        .result-card.best-rate::before {
            content: "BEST RATE";
            position: absolute;
            top: -10px;
            right: 15px;
            background: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .result-card.lowest-cost {
            border-left-color: #007bff;
            box-shadow: 0 15px 40px rgba(0, 123, 255, 0.2);
        }

        .result-card.lowest-cost::before {
            content: "LOWEST TOTAL COST";
            position: absolute;
            top: -10px;
            right: 15px;
            background: #007bff;
            color: white;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .lender-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8f9fa;
        }

        .lender-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
        }

        .lender-logo {
            font-size: 0.9rem;
            color: #666;
            font-weight: normal;
        }

        .rate-type {
            font-size: 1rem;
            color: #667eea;
            font-weight: 600;
        }

        .interest-rate {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
        }

        .monthly-payment {
            text-align: center;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .payment-amount {
            font-size: 2.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .payment-label {
            color: #666;
            font-size: 1rem;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .breakdown-item:last-child {
            border-bottom: none;
            font-weight: bold;
            background: #f8f9fa;
            margin: 10px -10px -10px -10px;
            padding: 15px 10px;
            border-radius: 8px;
        }

        .summary-section {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-top: 30px;
        }

        .summary-title {
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
        }

        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .comparison-item {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .comparison-value {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .comparison-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .savings-highlight {
            background: rgba(255,255,255,0.2);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .savings-amount {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .input-row {
                grid-template-columns: 1fr;
            }

            .results-section {
                grid-template-columns: 1fr;
            }

            .comparison-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="content-section">
        <h2 style="margin-bottom: 25px; color: #333; text-align: center;">Compare Real Lender Rates & Find the Best Deal</h2>

        <div class="input-section">
            <div class="input-row">
                <div class="input-group">
                    <label for="houseValue">House Value</label>
                    <div class="currency-input">
                        <input type="number" id="houseValue" value="500000" min="50000" step="5000" placeholder="500000">
                    </div>
                    <div class="quick-amounts">
                        <button class="quick-btn" onclick="setHouseValue(400000)">€400k</button>
                        <button class="quick-btn" onclick="setHouseValue(500000)">€500k</button>
                        <button class="quick-btn" onclick="setHouseValue(600000)">€600k</button>
                        <button class="quick-btn" onclick="setHouseValue(750000)">€750k</button>
                    </div>
                </div>

                <div class="input-group">
                    <label for="mortgageAmount">Mortgage Amount</label>
                    <div class="currency-input">
                        <input type="number" id="mortgageAmount" value="400000" min="10000" step="5000" placeholder="400000">
                    </div>
                    <div class="quick-amounts">
                        <button class="quick-btn" onclick="setLTV(80)">80% LTV</button>
                        <button class="quick-btn" onclick="setLTV(90)">90% LTV</button>
                        <button class="quick-btn" onclick="setLTV(95)">95% LTV</button>
                    </div>
                </div>

                <div class="input-group">
                    <label for="mortgageTerm">Mortgage Term</label>
                    <select id="mortgageTerm">
                        <option value="15">15 years</option>
                        <option value="20">20 years</option>
                        <option value="25" selected>25 years</option>
                        <option value="30">30 years</option>
                        <option value="35">35 years</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>LTV Ratio</label>
                    <div class="ltv-display">
                        <div class="ltv-percentage" id="ltvDisplay">80.0%</div>
                        <div class="ltv-label">Loan-to-Value</div>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <button class="btn" onclick="calculatePayments()" style="font-size: 1.2rem; padding: 15px 40px;">
                    🏦 Compare All Lenders
                </button>
            </div>
        </div>
    </div>

    <div class="best-deal-banner" id="bestDealBanner" style="display: none;">
        <div class="best-deal-title" id="bestDealTitle"></div>
        <div class="best-deal-details" id="bestDealDetails"></div>
    </div>

    <div class="results-section" id="resultsSection" style="display: none;">
        <!-- Results will be populated here -->
    </div>

    <div class="summary-section" id="summarySection" style="display: none;">
        <div class="summary-title">Mortgage Comparison Summary</div>
        <div class="comparison-grid" id="comparisonGrid">
            <!-- Comparison stats will be populated here -->
        </div>
        <div class="savings-highlight" id="savingsHighlight">
            <!-- Savings comparison will be populated here -->
        </div>
    </div>

    <script>
        // REAL DODDL RATES - Updated from your spreadsheet (10.02.2025)
        const irishLenders = [
            // AVANT MONEY
            {
                lender: "Avant",
                products: [
                    { name: "LTV Variable", rate: 3.75, term: "Variable", maxLTV: 100, minLTV: 0, monthlyPayment: 1575 },
                    { name: "3 Year Fixed", rate: 3.60, term: "3 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1546 },
                    { name: "4 Year Fixed", rate: 3.40, term: "4 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1508 },
                    { name: "5 Year Fixed", rate: 3.80, term: "5 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1584 },
                    { name: "7 Year Fixed", rate: 3.80, term: "7 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1584 },
                    { name: "10 Year Fixed", rate: 3.80, term: "10 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1584 },
                    { name: "15 Year Fixed", rate: 3.40, term: "15 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1508 },
                    { name: "20 Year Fixed", rate: 3.40, term: "20 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1508 },
                    { name: "25 Year Fixed", rate: 3.40, term: "25 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1508 },
                    { name: "30 Year Fixed", rate: 3.40, term: "30 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1508 }
                ]
            },
            // PERMANENT TSB
            {
                lender: "Permanent TSB",
                products: [
                    { name: "Standard Variable", rate: 4.70, term: "Variable", maxLTV: 90, minLTV: 0, monthlyPayment: 1763 },
                    { name: "LTV Variable", rate: 4.50, term: "Variable", maxLTV: 100, minLTV: 90, monthlyPayment: 1723 },
                    { name: "2 Year Fixed", rate: 4.20, term: "2 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1663 },
                    { name: "3 Year Fixed", rate: 3.80, term: "3 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1584 },
                    { name: "HVM >250K 3 Year", rate: 3.55, term: "3 Year Fixed", maxLTV: 70, minLTV: 0, monthlyPayment: 1536 },
                    { name: "4 Year Fixed", rate: 3.40, term: "4 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1508 },
                    { name: "Green 3 Year", rate: 3.60, term: "3 Year Fixed", maxLTV: 80, minLTV: 0, monthlyPayment: 1546 },
                    { name: "Green 5 Year", rate: 3.60, term: "5 Year Fixed", maxLTV: 80, minLTV: 0, monthlyPayment: 1546 },
                    { name: "Green HVM >250K", rate: 3.50, term: "Fixed", maxLTV: 70, minLTV: 0, monthlyPayment: 1527 }
                ]
            },
            // HAVEN (AIB GROUP)
            {
                lender: "Haven (AIB Group)",
                products: [
                    { name: "Standard Variable", rate: 4.15, term: "Variable", maxLTV: 90, minLTV: 0, monthlyPayment: 1653 },
                    { name: "LTV Variable", rate: 3.95, term: "Variable", maxLTV: 100, minLTV: 90, monthlyPayment: 1613 },
                    { name: "1 Year Fixed", rate: 4.55, term: "1 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1733 },
                    { name: "2 Year Fixed", rate: 4.65, term: "2 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1753 },
                    { name: "3 Year Fixed", rate: 4.75, term: "3 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1774 },
                    { name: "5 Year Fixed", rate: 4.85, term: "5 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1794 },
                    { name: "7 Year Fixed", rate: 5.05, term: "7 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1836 },
                    { name: "10 Year Fixed", rate: 5.15, term: "10 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1856 },
                    { name: "Green 4 Year", rate: 3.45, term: "4 Year Fixed", maxLTV: 80, minLTV: 0, monthlyPayment: 1517 }
                ]
            },
            // BANK OF IRELAND
            {
                lender: "Bank of Ireland",
                products: [
                    { name: "Standard Variable", rate: 4.15, term: "Variable", maxLTV: 90, minLTV: 0, monthlyPayment: 1653 },
                    { name: "1 Year Fixed", rate: 3.35, term: "1 Year Fixed", maxLTV: 80, minLTV: 0, monthlyPayment: 1498 },
                    { name: "2 Year Fixed", rate: 3.85, term: "2 Year Fixed", maxLTV: 80, minLTV: 0, monthlyPayment: 1594 },
                    { name: "3 Year Fixed", rate: 3.95, term: "3 Year Fixed", maxLTV: 80, minLTV: 0, monthlyPayment: 1613 },
                    { name: "Eco Saver 2 Year", rate: 3.15, term: "2 Year Fixed", maxLTV: 70, minLTV: 0, monthlyPayment: 1461 },
                    { name: "Eco Saver 3 Year", rate: 3.45, term: "3 Year Fixed", maxLTV: 70, minLTV: 0, monthlyPayment: 1517 },
                    { name: "Eco Saver 5 Year", rate: 3.50, term: "5 Year Fixed", maxLTV: 70, minLTV: 0, monthlyPayment: 1527 },
                    { name: "15 Year Fixed", rate: 4.25, term: "15 Year Fixed", maxLTV: 80, minLTV: 0, monthlyPayment: 1673 }
                ]
            },
            // FINANCE IRELAND
            {
                lender: "Finance Ireland",
                products: [
                    { name: "Standard Variable", rate: 5.90, term: "Variable", maxLTV: 90, minLTV: 0, monthlyPayment: 2017 },
                    { name: "LTV Variable", rate: 5.70, term: "Variable", maxLTV: 100, minLTV: 90, monthlyPayment: 1973 },
                    { name: "3 Year Fixed", rate: 5.80, term: "3 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1995 },
                    { name: "5 Year Fixed", rate: 5.60, term: "5 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1952 }
                ]
            },
            // ICS MORTGAGES
            {
                lender: "ICS Mortgages",
                products: [
                    { name: "Standard Variable", rate: 4.99, term: "Variable", maxLTV: 90, minLTV: 0, monthlyPayment: 1823 },
                    { name: "LTV Variable", rate: 4.99, term: "Variable", maxLTV: 100, minLTV: 90, monthlyPayment: 1823 },
                    { name: "3 Year Fixed", rate: 4.25, term: "3 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1673 },
                    { name: "5 Year Fixed", rate: 4.25, term: "5 Year Fixed", maxLTV: 90, minLTV: 0, monthlyPayment: 1673 }
                ]
            },
            // MOCO
            {
                lender: "MoCo",
                products: [
                    { name: "LTV Variable", rate: 3.95, term: "Variable", maxLTV: 100, minLTV: 0, monthlyPayment: 1613 },
                    { name: "3 Year Fixed", rate: 3.65, term: "3 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1555 },
                    { name: "5 Year Fixed", rate: 3.65, term: "5 Year Fixed", maxLTV: 100, minLTV: 0, monthlyPayment: 1555 }
                ]
            },
            // NUA MONEY
            {
                lender: "Nua Money",
                products: [
                    { name: "3 Year Fixed", rate: 4.15, term: "3 Year Fixed", maxLTV: 80, minLTV: 0, monthlyPayment: 1653 },
                    { name: "5 Year Fixed", rate: 4.05, term: "5 Year Fixed", maxLTV: 80, minLTV: 0, monthlyPayment: 1633 }
                ]
            }
        ];

        function updateLTV() {
            const houseValue = parseFloat(document.getElementById('houseValue').value) || 0;
            const mortgageAmount = parseFloat(document.getElementById('mortgageAmount').value) || 0;

            if (houseValue === 0) return 0;

            const ltv = (mortgageAmount / houseValue) * 100;
            document.getElementById('ltvDisplay').textContent = ltv.toFixed(1) + '%';

            return ltv;
        }

        function setHouseValue(value) {
            document.getElementById('houseValue').value = value;
            updateLTV();
        }

        function setLTV(percentage) {
            const houseValue = parseFloat(document.getElementById('houseValue').value) || 0;
            const mortgageAmount = houseValue * (percentage / 100);
            document.getElementById('mortgageAmount').value = Math.round(mortgageAmount);
            updateLTV();
        }

        function calculateMonthlyPayment(principal, annualRate, years) {
            const monthlyRate = annualRate / 100 / 12;
            const numberOfPayments = years * 12;

            if (monthlyRate === 0) {
                return principal / numberOfPayments;
            }

            return principal * (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) /
                (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
        }

        function getApplicableProducts(ltv) {
            let applicableProducts = [];

            irishLenders.forEach(lender => {
                lender.products.forEach(product => {
                    if (ltv <= product.maxLTV && ltv >= product.minLTV) {
                        applicableProducts.push({
                            lender: lender.lender,
                            ...product
                        });
                    }
                });
            });

            return applicableProducts;
        }

        function calculatePayments() {
            const houseValue = parseFloat(document.getElementById('houseValue').value);
            const mortgageAmount = parseFloat(document.getElementById('mortgageAmount').value);
            const years = parseInt(document.getElementById('mortgageTerm').value);

            if (!houseValue || !mortgageAmount || !years) {
                showAlert('Please fill in all fields', 'error');
                return;
            }

            if (mortgageAmount > houseValue) {
                showAlert('Mortgage amount cannot be greater than house value', 'error');
                return;
            }

            const ltv = updateLTV();
            const applicableProducts = getApplicableProducts(ltv);

            if (applicableProducts.length === 0) {
                showAlert('No mortgage products available for this LTV ratio. Consider a larger deposit.', 'error');
                return;
            }

            // For 30-year term, use the Doddl monthly payment directly
            // For other terms, calculate using the rate
            let calculations = applicableProducts.map(product => {
                let monthlyPayment;

                if (years === 30) {
                    // Use Doddl's precalculated payment for 30 years
                    // Scale it based on actual mortgage amount vs Doddl's €340k
                    const doddlMortgage = 340000;
                    monthlyPayment = (product.monthlyPayment * mortgageAmount) / doddlMortgage;
                } else {
                    // Calculate for other terms using the rate
                    monthlyPayment = calculateMonthlyPayment(mortgageAmount, product.rate, years);
                }

                const totalPaid = monthlyPayment * years * 12;
                const totalInterest = totalPaid - mortgageAmount;

                return {
                    ...product,
                    monthlyPayment,
                    totalPaid,
                    totalInterest
                };
            });

            // Sort by monthly payment (best rate first)
            calculations.sort((a, b) => a.monthlyPayment - b.monthlyPayment);

            // Find best rate and lowest total cost
            const bestRate = calculations[0];
            const lowestTotalCost = calculations.reduce((min, current) =>
                current.totalPaid < min.totalPaid ? current : min
            );

            // Show best deal banner
            document.getElementById('bestDealTitle').textContent =
                `Best Rate: ${bestRate.lender} ${bestRate.name} at ${bestRate.rate}%`;
            document.getElementById('bestDealDetails').textContent =
                `Monthly Payment: €${bestRate.monthlyPayment.toLocaleString('en-IE', {minimumFractionDigits: 2})} | Total Cost: €${bestRate.totalPaid.toLocaleString('en-IE', {minimumFractionDigits: 0})}`;
            document.getElementById('bestDealBanner').style.display = 'block';

            // Generate result cards (show top 8 to avoid clutter)
            let resultsHTML = '';
            const topCalculations = calculations.slice(0, 8);

            topCalculations.forEach((calc, index) => {
                let cardClass = '';
                if (calc === bestRate) cardClass = 'best-rate';
                else if (calc === lowestTotalCost && calc !== bestRate) cardClass = 'lowest-cost';

                resultsHTML += `
            <div class="result-card ${cardClass}">
                <div class="lender-header">
                    <div>
                        <div class="lender-name">${calc.lender}</div>
                        <div class="rate-type">${calc.name}</div>
                    </div>
                    <div class="interest-rate">${calc.rate.toFixed(2)}%</div>
                </div>

                <div class="monthly-payment">
                    <div class="payment-amount">€${calc.monthlyPayment.toLocaleString('en-IE', {minimumFractionDigits: 2})}</div>
                    <div class="payment-label">Monthly Payment</div>
                </div>

                <div class="breakdown-item">
                    <span>Rate Type:</span>
                    <span>${calc.term}</span>
                </div>
                <div class="breakdown-item">
                    <span>Mortgage Term:</span>
                    <span>${years} years</span>
                </div>
                <div class="breakdown-item">
                    <span>Total Interest:</span>
                    <span>€${calc.totalInterest.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                </div>
                <div class="breakdown-item">
                    <span>Total Cost Over ${years} Years:</span>
                    <span>€${calc.totalPaid.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                </div>
            </div>
        `;
            });

            document.getElementById('resultsSection').innerHTML = resultsHTML;
            document.getElementById('resultsSection').style.display = 'grid';

            // Generate summary comparison
            const worstRate = calculations[calculations.length - 1];
            const monthlyDifference = worstRate.monthlyPayment - bestRate.monthlyPayment;
            const lifetimeDifference = worstRate.totalPaid - bestRate.totalPaid;

            const comparisonHTML = `
        <div class="comparison-item">
            <div class="comparison-value">€${bestRate.monthlyPayment.toLocaleString('en-IE', {minimumFractionDigits: 2})}</div>
            <div class="comparison-label">Best Monthly Payment<br>(${bestRate.lender})</div>
        </div>
        <div class="comparison-item">
            <div class="comparison-value">€${lowestTotalCost.totalPaid.toLocaleString('en-IE', {minimumFractionDigits: 0})}</div>
            <div class="comparison-label">Lowest Total Cost<br>(${lowestTotalCost.lender})</div>
        </div>
        <div class="comparison-item">
            <div class="comparison-value">${bestRate.rate.toFixed(2)}%</div>
            <div class="comparison-label">Best Interest Rate<br>(${bestRate.lender})</div>
        </div>
        <div class="comparison-item">
            <div class="comparison-value">${applicableProducts.length}</div>
            <div class="comparison-label">Available Products<br>Compared</div>
        </div>
    `;

            const savingsHTML = `
        <div class="savings-amount">Save €${lifetimeDifference.toLocaleString('en-IE', {minimumFractionDigits: 0})}</div>
        <div>By choosing the best rate vs worst rate over ${years} years</div>
        <div style="margin-top: 10px; font-size: 0.9rem;">
            Monthly difference: €${monthlyDifference.toLocaleString('en-IE', {minimumFractionDigits: 2})}
        </div>
    `;

            document.getElementById('comparisonGrid').innerHTML = comparisonHTML;
            document.getElementById('savingsHighlight').innerHTML = savingsHTML;
            document.getElementById('summarySection').style.display = 'block';

            showAlert(`Compared ${applicableProducts.length} mortgage products - showing top ${Math.min(8, applicableProducts.length)} deals`);
        }

        // Auto-update LTV when inputs change
        document.getElementById('houseValue').addEventListener('input', updateLTV);
        document.getElementById('mortgageAmount').addEventListener('input', updateLTV);

        // Initialize with your example values to match Doddl
        document.getElementById('houseValue').value = 515000;
        document.getElementById('mortgageAmount').value = 340000;
        document.getElementById('mortgageTerm').value = 30;
        updateLTV();
        calculatePayments(); // Show initial calculation with your example
    </script>



<?php include 'footer.php'; ?>