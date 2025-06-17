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

        .input-group input.readonly {
            background: #e9ecef;
            color: #495057;
            cursor: not-allowed;
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

        /* Funds Section Styles */
        .funds-section {
            background: #e8f4fd;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 2px solid #667eea;
        }

        .funds-section h3 {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.3rem;
            text-align: center;
        }

        .funds-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .fund-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #ddd;
            transition: all 0.3s ease;
        }

        .fund-item:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .fund-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .fund-input {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e1e5e9;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            background: #f8f9fa;
            min-height: 40px;
        }

        .fund-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
        }

        .inheritance-note {
            margin-top: 8px;
            font-size: 0.85rem;
            color: #666;
            line-height: 1.4;
        }

        .inheritance-calculation {
            margin-top: 8px;
            padding: 8px 12px;
            background: #fff3cd;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #856404;
        }

        .mortgage-control {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            border: 2px solid #667eea;
        }

        .mortgage-control h4 {
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .available-funds-summary {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .funds-breakdown {
            display: flex;
            justify-content: space-around;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .fund-amount {
            background: white;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 0.9rem;
        }

        .fund-amount strong {
            color: #667eea;
        }

        .slider-container {
            margin: 20px 0;
        }

        .slider-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }

        .slider {
            width: 100%;
            height: 8px;
            border-radius: 5px;
            background: #ddd;
            outline: none;
            opacity: 0.7;
            transition: opacity 0.2s;
            -webkit-appearance: none;
            appearance: none;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #667eea;
            cursor: pointer;
            border: none;
        }

        .down-payment-display {
            background: #28a745;
            color: white;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 10px;
        }

        .mortgage-result {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 15px;
        }

        .mortgage-amount {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .mortgage-label {
            font-size: 0.9rem;
            opacity: 0.9;
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
            content: "BEST INITIAL RATE";
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
            content: "BEST OVERALL DEAL";
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
            margin: 15px 0;
            font-size: 0.9rem;
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

            .funds-grid {
                grid-template-columns: 1fr;
            }

            .funds-section {
                padding: 20px;
            }

            .mortgage-control {
                padding: 15px;
            }
        }
    </style>

    <div class="content-section">
        <h2 style="margin-bottom: 25px; color: #333; text-align: center;">Compare Real Lender Rates & Find the Best Deal</h2>

        <div class="funds-section">
            <h3>💰 Your Available Funds</h3>
            <div class="funds-grid">
                <div class="fund-item">
                    <label for="savingsFunds" class="fund-label">💰 Cash Savings</label>
                    <input type="number" id="savingsFunds" class="fund-input" value="40000" min="0" step="1000" placeholder="40000">
                </div>

                <div class="fund-item">
                    <label for="inheritanceFunds" class="fund-label">🏠 Inheritance (House Sale Price)</label>
                    <input type="number" id="inheritanceFunds" class="fund-input" value="370000" min="0" step="1000" placeholder="370000">
                    <div class="inheritance-note">
                        <strong>Note:</strong> Your 50% share calculated automatically<br>
                        • Estate Agent Fee: 1.25% of sale price<br>
                        • Solicitor Costs: €2,000 fixed fee
                    </div>
                    <div id="inheritanceCalculation" class="inheritance-calculation" style="display: none;">
                        <!-- Calculation details will appear here -->
                    </div>
                </div>
            </div>

            <div class="mortgage-control">
                <h4>🏦 Mortgage & Down Payment Control</h4>

                <div class="available-funds-summary">
                    <div class="funds-breakdown">
                        <div class="fund-amount">
                            <strong>€<span id="availableSavings">0</span></strong><br>
                            <small>Cash Savings</small>
                        </div>
                        <div class="fund-amount">
                            <strong>€<span id="availableInheritance">0</span></strong><br>
                            <small>Net Inheritance</small>
                        </div>
                        <div class="fund-amount">
                            <strong>€<span id="totalAvailableFunds">0</span></strong><br>
                            <small>Total Available</small>
                        </div>
                    </div>
                </div>

                <div class="slider-container">
                    <div class="slider-label">
                        <span>Down Payment from Your Funds</span>
                        <span id="downPaymentAmount">€0</span>
                    </div>
                    <input type="range" id="downPaymentSlider" class="slider" min="0" max="100" value="0" step="1000">
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: #666; margin-top: 5px;">
                        <span>€0</span>
                        <span id="maxDownPayment">€0</span>
                    </div>
                </div>

                <div class="down-payment-display">
                    <strong>Down Payment: €<span id="downPaymentDisplay">0</span></strong>
                </div>

                <div class="mortgage-result">
                    <div class="mortgage-amount">€<span id="finalMortgageAmount">0</span></div>
                    <div class="mortgage-label">Required Mortgage Amount</div>
                </div>
            </div>
        </div>

        <div class="input-section">
            <div class="input-row">
                <div class="input-group">
                    <label for="houseValue">House Value</label>
                    <div class="currency-input">
                        <input type="number" id="houseValue" value="515000" min="50000" step="5000" placeholder="500000">
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
                        <input type="number" id="mortgageAmount" class="readonly" readonly>
                    </div>
                    <small style="color: #666; font-size: 0.8rem;">Automatically calculated from slider above</small>
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
        // REAL DODDL RATES - Updated with Split Period Calculations
        const irishLenders = [
            // AVANT MONEY
            {
                lender: "Avant",
                standardVariableRate: 3.75, // SVR after fixed period ends
                products: [
                    { name: "LTV Variable", rate: 3.75, term: "Variable", fixedYears: 0, maxLTV: 100, minLTV: 0, monthlyPayment: 1575 },
                    { name: "3 Year Fixed", rate: 3.60, term: "3 Year Fixed", fixedYears: 3, maxLTV: 100, minLTV: 0, monthlyPayment: 1546 },
                    { name: "4 Year Fixed", rate: 3.40, term: "4 Year Fixed", fixedYears: 4, maxLTV: 100, minLTV: 0, monthlyPayment: 1508 },
                    { name: "5 Year Fixed", rate: 3.80, term: "5 Year Fixed", fixedYears: 5, maxLTV: 100, minLTV: 0, monthlyPayment: 1584 },
                    { name: "7 Year Fixed", rate: 3.80, term: "7 Year Fixed", fixedYears: 7, maxLTV: 100, minLTV: 0, monthlyPayment: 1584 },
                    { name: "10 Year Fixed", rate: 3.80, term: "10 Year Fixed", fixedYears: 10, maxLTV: 100, minLTV: 0, monthlyPayment: 1584 },
                    { name: "15 Year Fixed", rate: 3.40, term: "15 Year Fixed", fixedYears: 15, maxLTV: 100, minLTV: 0, monthlyPayment: 1508 },
                    { name: "20 Year Fixed", rate: 3.40, term: "20 Year Fixed", fixedYears: 20, maxLTV: 100, minLTV: 0, monthlyPayment: 1508 },
                    { name: "25 Year Fixed", rate: 3.40, term: "25 Year Fixed", fixedYears: 25, maxLTV: 100, minLTV: 0, monthlyPayment: 1508 },
                    { name: "30 Year Fixed", rate: 3.40, term: "30 Year Fixed", fixedYears: 30, maxLTV: 100, minLTV: 0, monthlyPayment: 1508 }
                ]
            },
            // PERMANENT TSB
            {
                lender: "Permanent TSB",
                standardVariableRate: 4.70, // Their standard variable rate
                products: [
                    { name: "Standard Variable", rate: 4.70, term: "Variable", fixedYears: 0, maxLTV: 90, minLTV: 0, monthlyPayment: 1763 },
                    { name: "LTV Variable", rate: 4.50, term: "Variable", fixedYears: 0, maxLTV: 100, minLTV: 90, monthlyPayment: 1723 },
                    { name: "2 Year Fixed", rate: 4.20, term: "2 Year Fixed", fixedYears: 2, maxLTV: 90, minLTV: 0, monthlyPayment: 1663 },
                    { name: "3 Year Fixed", rate: 3.80, term: "3 Year Fixed", fixedYears: 3, maxLTV: 90, minLTV: 0, monthlyPayment: 1584 },
                    { name: "HVM >250K 3 Year", rate: 3.55, term: "3 Year Fixed", fixedYears: 3, maxLTV: 70, minLTV: 0, monthlyPayment: 1536 },
                    { name: "4 Year Fixed", rate: 3.40, term: "4 Year Fixed", fixedYears: 4, maxLTV: 90, minLTV: 0, monthlyPayment: 1508 },
                    { name: "Green 3 Year", rate: 3.60, term: "3 Year Fixed", fixedYears: 3, maxLTV: 80, minLTV: 0, monthlyPayment: 1546 },
                    { name: "Green 5 Year", rate: 3.60, term: "5 Year Fixed", fixedYears: 5, maxLTV: 80, minLTV: 0, monthlyPayment: 1546 },
                    { name: "Green HVM >250K", rate: 3.50, term: "Fixed", fixedYears: 30, maxLTV: 70, minLTV: 0, monthlyPayment: 1527 }
                ]
            },
            // HAVEN (AIB GROUP)
            {
                lender: "Haven (AIB Group)",
                standardVariableRate: 4.15, // Their standard variable rate
                products: [
                    { name: "Standard Variable", rate: 4.15, term: "Variable", fixedYears: 0, maxLTV: 90, minLTV: 0, monthlyPayment: 1653 },
                    { name: "LTV Variable", rate: 3.95, term: "Variable", fixedYears: 0, maxLTV: 100, minLTV: 90, monthlyPayment: 1613 },
                    { name: "1 Year Fixed", rate: 4.55, term: "1 Year Fixed", fixedYears: 1, maxLTV: 90, minLTV: 0, monthlyPayment: 1733 },
                    { name: "2 Year Fixed", rate: 4.65, term: "2 Year Fixed", fixedYears: 2, maxLTV: 90, minLTV: 0, monthlyPayment: 1753 },
                    { name: "3 Year Fixed", rate: 4.75, term: "3 Year Fixed", fixedYears: 3, maxLTV: 90, minLTV: 0, monthlyPayment: 1774 },
                    { name: "5 Year Fixed", rate: 4.85, term: "5 Year Fixed", fixedYears: 5, maxLTV: 90, minLTV: 0, monthlyPayment: 1794 },
                    { name: "7 Year Fixed", rate: 5.05, term: "7 Year Fixed", fixedYears: 7, maxLTV: 90, minLTV: 0, monthlyPayment: 1836 },
                    { name: "10 Year Fixed", rate: 5.15, term: "10 Year Fixed", fixedYears: 10, maxLTV: 90, minLTV: 0, monthlyPayment: 1856 },
                    { name: "Green 4 Year", rate: 3.45, term: "4 Year Fixed", fixedYears: 4, maxLTV: 80, minLTV: 0, monthlyPayment: 1517 }
                ]
            },
            // BANK OF IRELAND
            {
                lender: "Bank of Ireland",
                standardVariableRate: 4.15, // Their standard variable rate
                products: [
                    { name: "Standard Variable", rate: 4.15, term: "Variable", fixedYears: 0, maxLTV: 90, minLTV: 0, monthlyPayment: 1653 },
                    { name: "1 Year Fixed", rate: 3.35, term: "1 Year Fixed", fixedYears: 1, maxLTV: 80, minLTV: 0, monthlyPayment: 1498 },
                    { name: "2 Year Fixed", rate: 3.85, term: "2 Year Fixed", fixedYears: 2, maxLTV: 80, minLTV: 0, monthlyPayment: 1594 },
                    { name: "3 Year Fixed", rate: 3.95, term: "3 Year Fixed", fixedYears: 3, maxLTV: 80, minLTV: 0, monthlyPayment: 1613 },
                    { name: "Eco Saver 2 Year", rate: 3.15, term: "2 Year Fixed", fixedYears: 2, maxLTV: 70, minLTV: 0, monthlyPayment: 1461 },
                    { name: "Eco Saver 3 Year", rate: 3.45, term: "3 Year Fixed", fixedYears: 3, maxLTV: 70, minLTV: 0, monthlyPayment: 1517 },
                    { name: "Eco Saver 5 Year", rate: 3.50, term: "5 Year Fixed", fixedYears: 5, maxLTV: 70, minLTV: 0, monthlyPayment: 1527 },
                    { name: "15 Year Fixed", rate: 4.25, term: "15 Year Fixed", fixedYears: 15, maxLTV: 80, minLTV: 0, monthlyPayment: 1673 }
                ]
            },
            // FINANCE IRELAND
            {
                lender: "Finance Ireland",
                standardVariableRate: 5.90, // Their standard variable rate
                products: [
                    { name: "Standard Variable", rate: 5.90, term: "Variable", fixedYears: 0, maxLTV: 90, minLTV: 0, monthlyPayment: 2017 },
                    { name: "LTV Variable", rate: 5.70, term: "Variable", fixedYears: 0, maxLTV: 100, minLTV: 90, monthlyPayment: 1973 },
                    { name: "3 Year Fixed", rate: 5.80, term: "3 Year Fixed", fixedYears: 3, maxLTV: 90, minLTV: 0, monthlyPayment: 1995 },
                    { name: "5 Year Fixed", rate: 5.60, term: "5 Year Fixed", fixedYears: 5, maxLTV: 90, minLTV: 0, monthlyPayment: 1952 }
                ]
            },
            // ICS MORTGAGES
            {
                lender: "ICS Mortgages",
                standardVariableRate: 4.99, // Their standard variable rate
                products: [
                    { name: "Standard Variable", rate: 4.99, term: "Variable", fixedYears: 0, maxLTV: 90, minLTV: 0, monthlyPayment: 1823 },
                    { name: "LTV Variable", rate: 4.99, term: "Variable", fixedYears: 0, maxLTV: 100, minLTV: 90, monthlyPayment: 1823 },
                    { name: "3 Year Fixed", rate: 4.25, term: "3 Year Fixed", fixedYears: 3, maxLTV: 90, minLTV: 0, monthlyPayment: 1673 },
                    { name: "5 Year Fixed", rate: 4.25, term: "5 Year Fixed", fixedYears: 5, maxLTV: 90, minLTV: 0, monthlyPayment: 1673 }
                ]
            },
            // MOCO
            {
                lender: "MoCo",
                standardVariableRate: 3.95, // Their standard variable rate
                products: [
                    { name: "LTV Variable", rate: 3.95, term: "Variable", fixedYears: 0, maxLTV: 100, minLTV: 0, monthlyPayment: 1613 },
                    { name: "3 Year Fixed", rate: 3.65, term: "3 Year Fixed", fixedYears: 3, maxLTV: 100, minLTV: 0, monthlyPayment: 1555 },
                    { name: "5 Year Fixed", rate: 3.65, term: "5 Year Fixed", fixedYears: 5, maxLTV: 100, minLTV: 0, monthlyPayment: 1555 }
                ]
            },
            // NUA MONEY
            {
                lender: "Nua Money",
                standardVariableRate: 4.15, // Assuming similar to market
                products: [
                    { name: "3 Year Fixed", rate: 4.15, term: "3 Year Fixed", fixedYears: 3, maxLTV: 80, minLTV: 0, monthlyPayment: 1653 },
                    { name: "5 Year Fixed", rate: 4.05, term: "5 Year Fixed", fixedYears: 5, maxLTV: 80, minLTV: 0, monthlyPayment: 1633 }
                ]
            }
        ];

        function calculateInheritance() {
            const houseSalePrice = parseFloat(document.getElementById('inheritanceFunds').value) || 0;
            const calculationDiv = document.getElementById('inheritanceCalculation');

            if (houseSalePrice === 0) {
                calculationDiv.style.display = 'none';
                return 0;
            }

            const eaFee = houseSalePrice * 0.0125; // 1.25% of full sale price
            const solicitorFee = 2000;
            const netProceeds = houseSalePrice - eaFee - solicitorFee;
            const yourShare = netProceeds * 0.5; // 50% of net proceeds

            calculationDiv.innerHTML = `
                <strong>Inheritance Calculation:</strong><br>
                House Sale Price: €${houseSalePrice.toLocaleString('en-IE', {minimumFractionDigits: 0})}<br>
                Less EA Fee (1.25%): -€${eaFee.toLocaleString('en-IE', {minimumFractionDigits: 0})}<br>
                Less Solicitor: -€${solicitorFee.toLocaleString('en-IE', {minimumFractionDigits: 0})}<br>
                Net Proceeds: €${netProceeds.toLocaleString('en-IE', {minimumFractionDigits: 0})}<br>
                <strong>Your 50% Share: €${yourShare.toLocaleString('en-IE', {minimumFractionDigits: 0})}</strong>
            `;
            calculationDiv.style.display = 'block';

            return Math.max(0, yourShare);
        }

        function updateAvailableFunds() {
            const savings = parseFloat(document.getElementById('savingsFunds').value) || 0;
            const netInheritance = calculateInheritance();
            const totalAvailable = savings + netInheritance;

            // Update display
            document.getElementById('availableSavings').textContent = savings.toLocaleString('en-IE', {minimumFractionDigits: 0});
            document.getElementById('availableInheritance').textContent = netInheritance.toLocaleString('en-IE', {minimumFractionDigits: 0});
            document.getElementById('totalAvailableFunds').textContent = totalAvailable.toLocaleString('en-IE', {minimumFractionDigits: 0});

            // Update slider max
            const slider = document.getElementById('downPaymentSlider');
            slider.max = totalAvailable;
            document.getElementById('maxDownPayment').textContent = '€' + totalAvailable.toLocaleString('en-IE', {minimumFractionDigits: 0});

            // Reset slider if current value exceeds new max
            if (parseFloat(slider.value) > totalAvailable) {
                slider.value = totalAvailable;
            }

            updateMortgageCalculation();
            return totalAvailable;
        }

        function updateMortgageCalculation() {
            const houseValue = parseFloat(document.getElementById('houseValue').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPaymentSlider').value) || 0;
            const requiredMortgage = Math.max(0, houseValue - downPayment);

            // Update displays
            document.getElementById('downPaymentAmount').textContent = '€' + downPayment.toLocaleString('en-IE', {minimumFractionDigits: 0});
            document.getElementById('downPaymentDisplay').textContent = downPayment.toLocaleString('en-IE', {minimumFractionDigits: 0});
            document.getElementById('mortgageAmount').value = requiredMortgage;
            document.getElementById('finalMortgageAmount').textContent = requiredMortgage.toLocaleString('en-IE', {minimumFractionDigits: 0});

            updateLTV();
            return requiredMortgage;
        }

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
            updateMortgageCalculation();
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

        function calculateSplitPeriodMortgage(mortgageAmount, fixedRate, fixedYears, variableRate, totalYears) {
            // Calculate fixed period payment
            const fixedMonthlyPayment = calculateMonthlyPayment(mortgageAmount, fixedRate, totalYears);
            const fixedMonthlyRate = fixedRate / 100 / 12;
            const fixedPayments = fixedYears * 12;

            // Calculate remaining balance after fixed period
            let remainingBalance = mortgageAmount;
            for (let month = 0; month < fixedPayments; month++) {
                const interestPayment = remainingBalance * fixedMonthlyRate;
                const principalPayment = fixedMonthlyPayment - interestPayment;
                remainingBalance -= principalPayment;
            }

            // Calculate variable period payment for remaining balance
            const remainingYears = totalYears - fixedYears;
            const variableMonthlyPayment = calculateMonthlyPayment(remainingBalance, variableRate, remainingYears);

            // Calculate total costs
            const fixedPeriodCost = fixedMonthlyPayment * fixedPayments;
            const variablePeriodCost = variableMonthlyPayment * (remainingYears * 12);
            const totalCost = fixedPeriodCost + variablePeriodCost;
            const totalInterest = totalCost - mortgageAmount;

            return {
                fixedMonthlyPayment,
                variableMonthlyPayment,
                fixedPeriodCost,
                variablePeriodCost,
                totalCost,
                totalInterest,
                remainingBalance,
                fixedYears,
                remainingYears
            };
        }

        function getApplicableProducts(ltv) {
            let applicableProducts = [];

            irishLenders.forEach(lender => {
                lender.products.forEach(product => {
                    if (ltv <= product.maxLTV && ltv >= product.minLTV) {
                        applicableProducts.push({
                            lender: lender.lender,
                            standardVariableRate: lender.standardVariableRate,
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

            // Calculate all products with split period logic
            let calculations = applicableProducts.map(product => {
                let monthlyPayment, totalPaid, totalInterest;
                let splitPeriodData = null;

                // Check if this is a fixed-rate product that will revert to variable
                const needsSplitCalculation = product.fixedYears > 0 && product.fixedYears < years;

                if (needsSplitCalculation) {
                    // Find the lender's standard variable rate
                    const lender = irishLenders.find(l => l.lender === product.lender);
                    const variableRate = lender ? lender.standardVariableRate : product.rate + 1; // fallback

                    splitPeriodData = calculateSplitPeriodMortgage(
                        mortgageAmount,
                        product.rate,
                        product.fixedYears,
                        variableRate,
                        years
                    );

                    monthlyPayment = splitPeriodData.fixedMonthlyPayment; // Show fixed period payment as primary
                    totalPaid = splitPeriodData.totalCost;
                    totalInterest = splitPeriodData.totalInterest;
                } else {
                    // Standard calculation for variable rates or full-term fixed rates
                    if (years === 30) {
                        const doddlMortgage = 340000;
                        monthlyPayment = (product.monthlyPayment * mortgageAmount) / doddlMortgage;
                    } else {
                        monthlyPayment = calculateMonthlyPayment(mortgageAmount, product.rate, years);
                    }

                    totalPaid = monthlyPayment * years * 12;
                    totalInterest = totalPaid - mortgageAmount;
                }

                return {
                    ...product,
                    monthlyPayment,
                    totalPaid,
                    totalInterest,
                    splitPeriodData,
                    needsSplitCalculation
                };
            });

            // Sort by total cost over full term (not just monthly payment)
            calculations.sort((a, b) => a.totalPaid - b.totalPaid);

            // Find best rate and lowest total cost
            const lowestTotalCost = calculations[0]; // Already sorted by total cost
            const bestInitialRate = calculations.reduce((min, current) =>
                current.rate < min.rate ? current : min
            );

            // Show best deal banner
            document.getElementById('bestDealTitle').textContent =
                `Best Overall Deal: ${lowestTotalCost.lender} ${lowestTotalCost.name}`;
            document.getElementById('bestDealDetails').textContent =
                `Total Cost Over ${years} Years: €${lowestTotalCost.totalPaid.toLocaleString('en-IE', {minimumFractionDigits: 0})} | Initial Rate: ${lowestTotalCost.rate}%${lowestTotalCost.needsSplitCalculation ? ' (fixed for ' + lowestTotalCost.fixedYears + ' years)' : ''}`;
            document.getElementById('bestDealBanner').style.display = 'block';

            // Generate result cards (show top 8 to avoid clutter)
            let resultsHTML = '';
            const topCalculations = calculations.slice(0, 8);

            topCalculations.forEach((calc, index) => {
                let cardClass = '';
                if (calc === lowestTotalCost) cardClass = 'lowest-cost';
                else if (calc === bestInitialRate && calc !== lowestTotalCost) cardClass = 'best-rate';

                let splitPeriodHTML = '';
                if (calc.needsSplitCalculation && calc.splitPeriodData) {
                    const split = calc.splitPeriodData;
                    splitPeriodHTML = `
                    <div class="alert-warning" style="margin: 15px 0;">
                        <strong>⚠️ Rate Changes After ${split.fixedYears} Years</strong><br>
                        <small>After the fixed period, this mortgage reverts to the lender's standard variable rate</small>
                    </div>
                    <div class="breakdown-item">
                        <span>Years 1-${split.fixedYears} (Fixed ${calc.rate.toFixed(2)}%):</span>
                        <span>€${split.fixedMonthlyPayment.toLocaleString('en-IE', {minimumFractionDigits: 2})}/month</span>
                    </div>
                    <div class="breakdown-item">
                        <span>Years ${split.fixedYears + 1}-${years} (Variable):</span>
                        <span>€${split.variableMonthlyPayment.toLocaleString('en-IE', {minimumFractionDigits: 2})}/month</span>
                    </div>
                    <div class="breakdown-item">
                        <span>Remaining Balance After ${split.fixedYears} Years:</span>
                        <span>€${split.remainingBalance.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                    </div>
                `;
                }

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
                    <div class="payment-label">${calc.needsSplitCalculation ? `Initial Monthly Payment (${calc.splitPeriodData.fixedYears} years)` : 'Monthly Payment'}</div>
                </div>

                ${splitPeriodHTML}

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
            const worstTotalCost = calculations[calculations.length - 1];
            const lifetimeDifference = worstTotalCost.totalPaid - lowestTotalCost.totalPaid;

            const comparisonHTML = `
        <div class="comparison-item">
            <div class="comparison-value">€${lowestTotalCost.totalPaid.toLocaleString('en-IE', {minimumFractionDigits: 0})}</div>
            <div class="comparison-label">Lowest Total Cost<br>(${lowestTotalCost.lender})</div>
        </div>
        <div class="comparison-item">
            <div class="comparison-value">€${bestInitialRate.monthlyPayment.toLocaleString('en-IE', {minimumFractionDigits: 2})}</div>
            <div class="comparison-label">Best Initial Rate<br>(${bestInitialRate.lender} - ${bestInitialRate.rate}%)</div>
        </div>
        <div class="comparison-item">
            <div class="comparison-value">${lowestTotalCost.needsSplitCalculation ? lowestTotalCost.splitPeriodData.fixedYears + ' yr fixed' : 'Full term'}</div>
            <div class="comparison-label">Best Deal Fixed Period<br>(${lowestTotalCost.lender})</div>
        </div>
        <div class="comparison-item">
            <div class="comparison-value">${applicableProducts.length}</div>
            <div class="comparison-label">Available Products<br>Compared</div>
        </div>
    `;

            const savingsHTML = `
        <div class="savings-amount">Save €${lifetimeDifference.toLocaleString('en-IE', {minimumFractionDigits: 0})}</div>
        <div>By choosing the best overall deal vs worst deal over ${years} years</div>
        <div style="margin-top: 10px; font-size: 0.9rem;">
            Best deal: ${lowestTotalCost.lender} ${lowestTotalCost.name}
        </div>
    `;

            document.getElementById('comparisonGrid').innerHTML = comparisonHTML;
            document.getElementById('savingsHighlight').innerHTML = savingsHTML;
            document.getElementById('summarySection').style.display = 'block';

            showAlert(`Compared ${applicableProducts.length} mortgage products - showing top ${Math.min(8, applicableProducts.length)} deals`);
        }

        // Event listeners
        document.getElementById('houseValue').addEventListener('input', updateMortgageCalculation);
        document.getElementById('mortgageTerm').addEventListener('input', () => {
            if (parseFloat(document.getElementById('mortgageAmount').value) > 0) {
                calculatePayments();
            }
        });

        // Auto-update funds when any fund input changes
        document.querySelectorAll('#savingsFunds, #inheritanceFunds').forEach(input => {
            input.addEventListener('input', () => {
                updateAvailableFunds();
            });
        });

        // Slider event listener
        document.getElementById('downPaymentSlider').addEventListener('input', () => {
            updateMortgageCalculation();
        });

        // Initialize
        updateAvailableFunds();
        updateMortgageCalculation();
        calculatePayments(); // Show initial calculation with example values
    </script>

<?php include 'footer.php'; ?>