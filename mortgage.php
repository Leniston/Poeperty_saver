<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mortgage Calculator</title>
    <!-- Mobile App-like experience -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Mortgage Calculator">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💰</text></svg>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .navigation {
            text-align: center;
            margin-bottom: 30px;
        }

        .nav-link {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 25px;
            margin: 0 10px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .calculator-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .input-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .input-group {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
        }

        .input-group h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            align-items: center;
        }

        .form-row label {
            min-width: 120px;
            font-weight: 600;
            color: #555;
        }

        .form-row input, .form-row select {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-row input:focus, .form-row select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .result-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-top: 5px solid;
            transition: transform 0.3s ease;
        }

        .result-card:hover {
            transform: translateY(-5px);
        }

        .result-card.fixed-rate {
            border-top-color: #28a745;
        }

        .result-card.variable-rate {
            border-top-color: #17a2b8;
        }

        .result-card.tracker-rate {
            border-top-color: #ffc107;
        }

        .result-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .rate-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .rate-display {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }

        .rate-details {
            font-size: 0.9rem;
            color: #666;
        }

        .payment-breakdown {
            margin-bottom: 20px;
        }

        .payment-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .payment-item:last-child {
            border-bottom: none;
        }

        .payment-label {
            color: #666;
        }

        .payment-value {
            font-weight: 600;
            color: #333;
        }

        .monthly-payment {
            font-size: 1.8rem;
            color: #667eea;
            font-weight: bold;
        }

        .lifetime-cost {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .lifetime-amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .lifetime-label {
            color: #666;
            margin-bottom: 5px;
        }

        .rate-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .rate-table th,
        .rate-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .rate-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .rate-table tr:last-child td {
            border-bottom: none;
        }

        .ltv-info {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #ffc107;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        @media (max-width: 768px) {
            .input-grid {
                grid-template-columns: 1fr;
            }

            .results-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                flex-direction: column;
                align-items: stretch;
            }

            .form-row label {
                min-width: auto;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>💰 Mortgage Calculator</h1>
        <p>Calculate monthly payments and total costs for different mortgage scenarios</p>
    </div>

    <div class="navigation">
        <a href="index.php" class="nav-link">🏠 Property Saver</a>
        <a href="calculator.php" class="nav-link">💰 Property Calculator</a>
        <a href="mortgage.php" class="nav-link active">📊 Mortgage Calculator</a>
    </div>

    <div id="alert" class="alert"></div>

    <div class="calculator-section">
        <div class="input-grid">
            <div class="input-group">
                <h3>Mortgage Details</h3>
                <div class="form-row">
                    <label>Mortgage Amount:</label>
                    <input type="number" id="mortgageAmount" value="400000" min="10000" step="1000" placeholder="€400,000">
                </div>
                <div class="form-row">
                    <label>Mortgage Term:</label>
                    <select id="mortgageTerm">
                        <option value="15">15 years</option>
                        <option value="20">20 years</option>
                        <option value="25" selected>25 years</option>
                        <option value="30">30 years</option>
                        <option value="35">35 years</option>
                    </select>
                </div>
                <div class="form-row">
                    <label>Property Value:</label>
                    <input type="number" id="propertyValue" value="500000" min="10000" step="1000" placeholder="€500,000">
                </div>
            </div>

            <div class="input-group">
                <h3>Personal Details</h3>
                <div class="form-row">
                    <label>First Time Buyer:</label>
                    <select id="firstTimeBuyer">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="form-row">
                    <label>Income Type:</label>
                    <select id="incomeType">
                        <option value="employed">Employed/PAYE</option>
                        <option value="self-employed">Self-Employed</option>
                        <option value="mixed">Mixed Income</option>
                    </select>
                </div>
                <div class="form-row">
                    <label>Green Mortgage:</label>
                    <select id="greenMortgage">
                        <option value="no">No</option>
                        <option value="yes">Yes (A/B BER rating)</option>
                    </select>
                </div>
            </div>
        </div>

        <button class="btn" onclick="calculateMortgage()">📊 Calculate All Scenarios</button>

        <div class="ltv-info" id="ltvInfo" style="display: none;">
            <strong>Loan-to-Value (LTV) Ratio:</strong> <span id="ltvRatio"></span>
            <br><small>This affects which rates are available to you.</small>
        </div>
    </div>

    <div class="results-grid" id="resultsGrid" style="display: none;">
        <!-- Results will be populated here -->
    </div>

    <div class="calculator-section" id="rateTableSection" style="display: none;">
        <h3>Current Interest Rates</h3>
        <table class="rate-table" id="rateTable">
            <thead>
            <tr>
                <th>Rate Type</th>
                <th>LTV</th>
                <th>Term</th>
                <th>Interest Rate</th>
                <th>APR</th>
                <th>Special Conditions</th>
            </tr>
            </thead>
            <tbody id="rateTableBody">
            <!-- Rates will be populated here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    // Mortgage rates data structure (based on typical Irish mortgage rates)
    const mortgageRates = {
        fixed: [
            { ltv: 80, term: 'all', rate: 3.25, apr: 3.31, type: 'Fixed 1 Year', conditions: 'First time buyers' },
            { ltv: 80, term: 'all', rate: 3.45, apr: 3.51, type: 'Fixed 2 Year', conditions: 'Standard' },
            { ltv: 80, term: 'all', rate: 3.65, apr: 3.71, type: 'Fixed 3 Year', conditions: 'Standard' },
            { ltv: 80, term: 'all', rate: 3.85, apr: 3.91, type: 'Fixed 5 Year', conditions: 'Standard' },
            { ltv: 90, term: 'all', rate: 3.75, apr: 3.81, type: 'Fixed 1 Year', conditions: 'Higher LTV' },
            { ltv: 90, term: 'all', rate: 3.95, apr: 4.01, type: 'Fixed 2 Year', conditions: 'Higher LTV' },
            { ltv: 95, term: 'all', rate: 4.15, apr: 4.21, type: 'Fixed 2 Year', conditions: 'High LTV' }
        ],
        variable: [
            { ltv: 80, term: 'all', rate: 3.95, apr: 4.01, type: 'Variable Rate', conditions: 'Standard' },
            { ltv: 90, term: 'all', rate: 4.25, apr: 4.31, type: 'Variable Rate', conditions: 'Higher LTV' },
            { ltv: 95, term: 'all', rate: 4.55, apr: 4.61, type: 'Variable Rate', conditions: 'High LTV' }
        ],
        tracker: [
            { ltv: 80, term: 'all', rate: 3.15, apr: 3.21, type: 'Tracker (ECB + 2.5%)', conditions: 'Green mortgage' },
            { ltv: 80, term: 'all', rate: 3.35, apr: 3.41, type: 'Tracker (ECB + 2.7%)', conditions: 'Standard' },
            { ltv: 90, term: 'all', rate: 3.65, apr: 3.71, type: 'Tracker (ECB + 3.0%)', conditions: 'Higher LTV' }
        ]
    };

    function showAlert(message, type = 'info') {
        const alert = document.getElementById('alert');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;
        alert.style.display = 'block';
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    }

    function calculateLTV() {
        const mortgageAmount = parseFloat(document.getElementById('mortgageAmount').value) || 0;
        const propertyValue = parseFloat(document.getElementById('propertyValue').value) || 0;

        if (propertyValue === 0) return 0;
        return (mortgageAmount / propertyValue) * 100;
    }

    function getApplicableRates() {
        const ltv = calculateLTV();
        const isFirstTime = document.getElementById('firstTimeBuyer').value === 'yes';
        const isGreen = document.getElementById('greenMortgage').value === 'yes';

        let applicableRates = {
            fixed: [],
            variable: [],
            tracker: []
        };

        // Filter rates based on LTV
        Object.keys(mortgageRates).forEach(rateType => {
            applicableRates[rateType] = mortgageRates[rateType].filter(rate => {
                return ltv <= rate.ltv;
            });
        });

        // Apply discounts for special conditions
        Object.keys(applicableRates).forEach(rateType => {
            applicableRates[rateType] = applicableRates[rateType].map(rate => {
                let adjustedRate = { ...rate };

                // First time buyer discount
                if (isFirstTime && rate.conditions.includes('First time')) {
                    adjustedRate.rate -= 0.1;
                    adjustedRate.apr -= 0.1;
                }

                // Green mortgage discount
                if (isGreen && rateType === 'tracker' && rate.conditions.includes('Green')) {
                    adjustedRate.rate -= 0.2;
                    adjustedRate.apr -= 0.2;
                }

                return adjustedRate;
            });
        });

        return applicableRates;
    }

    function calculateMonthlyPayment(principal, annualRate, years) {
        const monthlyRate = annualRate / 100 / 12;
        const numberOfPayments = years * 12;

        if (monthlyRate === 0) {
            return principal / numberOfPayments;
        }

        const monthlyPayment = principal *
            (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) /
            (Math.pow(1 + monthlyRate, numberOfPayments) - 1);

        return monthlyPayment;
    }

    function renderRateScenario(rateType, rate, mortgageAmount, years) {
        const monthlyPayment = calculateMonthlyPayment(mortgageAmount, rate.rate, years);
        const totalPaid = monthlyPayment * years * 12;
        const totalInterest = totalPaid - mortgageAmount;

        const typeColors = {
            fixed: 'fixed-rate',
            variable: 'variable-rate',
            tracker: 'tracker-rate'
        };

        return `
            <div class="result-card ${typeColors[rateType]}">
                <div class="result-title">${rate.type}</div>

                <div class="rate-info">
                    <div class="rate-display">${rate.rate.toFixed(2)}%</div>
                    <div class="rate-details">APR: ${rate.apr.toFixed(2)}% | ${rate.conditions}</div>
                </div>

                <div class="payment-breakdown">
                    <div class="payment-item">
                        <span class="payment-label">Monthly Payment:</span>
                        <span class="payment-value monthly-payment">€${monthlyPayment.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                    </div>
                    <div class="payment-item">
                        <span class="payment-label">Principal:</span>
                        <span class="payment-value">€${mortgageAmount.toLocaleString('en-IE')}</span>
                    </div>
                    <div class="payment-item">
                        <span class="payment-label">Total Interest:</span>
                        <span class="payment-value">€${totalInterest.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                    </div>
                    <div class="payment-item">
                        <span class="payment-label">Mortgage Term:</span>
                        <span class="payment-value">${years} years</span>
                    </div>
                </div>

                <div class="lifetime-cost">
                    <div class="lifetime-label">Total Amount Payable</div>
                    <div class="lifetime-amount">€${totalPaid.toLocaleString('en-IE', {minimumFractionDigits: 2})}</div>
                </div>
            </div>
        `;
    }

    function populateRateTable(rates) {
        const tbody = document.getElementById('rateTableBody');
        let html = '';

        Object.keys(rates).forEach(rateType => {
            rates[rateType].forEach(rate => {
                html += `
                    <tr>
                        <td>${rate.type}</td>
                        <td>≤${rate.ltv}%</td>
                        <td>${rate.term === 'all' ? 'All terms' : rate.term}</td>
                        <td><strong>${rate.rate.toFixed(2)}%</strong></td>
                        <td>${rate.apr.toFixed(2)}%</td>
                        <td>${rate.conditions}</td>
                    </tr>
                `;
            });
        });

        tbody.innerHTML = html;
    }

    function calculateMortgage() {
        const mortgageAmount = parseFloat(document.getElementById('mortgageAmount').value);
        const years = parseInt(document.getElementById('mortgageTerm').value);
        const propertyValue = parseFloat(document.getElementById('propertyValue').value);

        if (!mortgageAmount || !years || !propertyValue) {
            showAlert('Please fill in all required fields', 'error');
            return;
        }

        if (mortgageAmount > propertyValue) {
            showAlert('Mortgage amount cannot be greater than property value', 'error');
            return;
        }

        const ltv = calculateLTV();
        const applicableRates = getApplicableRates();

        // Show LTV info
        document.getElementById('ltvRatio').textContent = `${ltv.toFixed(1)}%`;
        document.getElementById('ltvInfo').style.display = 'block';

        // Generate results
        let resultsHTML = '';

        // Get best rate from each category
        const bestRates = {
            fixed: applicableRates.fixed.sort((a, b) => a.rate - b.rate)[0],
            variable: applicableRates.variable.sort((a, b) => a.rate - b.rate)[0],
            tracker: applicableRates.tracker.sort((a, b) => a.rate - b.rate)[0]
        };

        Object.keys(bestRates).forEach(rateType => {
            if (bestRates[rateType]) {
                resultsHTML += renderRateScenario(rateType, bestRates[rateType], mortgageAmount, years);
            }
        });

        if (resultsHTML === '') {
            resultsHTML = '<div class="alert alert-info">No suitable mortgage rates found for your criteria. You may need a larger deposit.</div>';
        }

        document.getElementById('resultsGrid').innerHTML = resultsHTML;
        document.getElementById('resultsGrid').style.display = 'grid';

        // Populate rate table
        populateRateTable(applicableRates);
        document.getElementById('rateTableSection').style.display = 'block';

        showAlert(`Calculated mortgage scenarios for ${ltv.toFixed(1)}% LTV ratio`);
    }

    // Auto-calculate when inputs change
    document.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('change', () => {
            const mortgageAmount = parseFloat(document.getElementById('mortgageAmount').value);
            const propertyValue = parseFloat(document.getElementById('propertyValue').value);

            if (mortgageAmount && propertyValue) {
                const ltv = calculateLTV();
                if (ltv > 0) {
                    document.getElementById('ltvRatio').textContent = `${ltv.toFixed(1)}%`;
                    document.getElementById('ltvInfo').style.display = 'block';
                }
            }
        });
    });

    // Initialize with default calculation
    calculateMortgage();
</script>
</body>
</html>