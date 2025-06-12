<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Calculator</title>
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

        .property-selector {
            margin-bottom: 30px;
        }

        .property-selector h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .property-dropdown {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .property-dropdown select {
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            background: #f8f9fa;
            min-width: 200px;
        }

        .manual-input {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .manual-input input {
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            background: #f8f9fa;
            width: 150px;
        }

        .funds-section {
            background: #e8f4fd;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .funds-section h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .funds-input {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .funds-input input {
            padding: 15px;
            border: 2px solid #667eea;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: bold;
            width: 200px;
            background: white;
        }

        .costs-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .costs-table th,
        .costs-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .costs-table th {
            background: #667eea;
            color: white;
            font-weight: 600;
        }

        .costs-table input {
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 4px;
            width: 100%;
            text-align: right;
        }

        .category-header {
            background: #f8f9fa !important;
            font-weight: bold;
            color: #333 !important;
        }

        .scenarios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .scenario-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border-top: 5px solid;
            transition: transform 0.3s ease;
        }

        .scenario-card:hover {
            transform: translateY(-5px);
        }

        .scenario-asking {
            border-top-color: #28a745;
        }

        .scenario-10 {
            border-top-color: #ffc107;
        }

        .scenario-15 {
            border-top-color: #dc3545;
        }

        .scenario-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .cost-breakdown {
            margin-bottom: 20px;
        }

        .cost-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .cost-item:last-child {
            border-bottom: none;
        }

        .cost-label {
            color: #666;
        }

        .cost-value {
            font-weight: 600;
            color: #333;
        }

        .house-price {
            font-size: 1.2rem;
            color: #667eea;
            font-weight: bold;
        }

        .total-cost {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .total-cost .cost-item {
            font-size: 1.1rem;
            font-weight: bold;
            border-bottom: none;
        }

        .remaining-money {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .remaining-money.negative {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .remaining-amount {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .remaining-label {
            opacity: 0.9;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .scenarios-grid {
                grid-template-columns: 1fr;
            }

            .property-dropdown {
                flex-direction: column;
                align-items: stretch;
            }

            .manual-input {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>💰 Property Calculator</h1>
        <p>Calculate total costs and remaining funds for different scenarios</p>
    </div>

    <div class="navigation">
        <a href="index.php" class="nav-link">🏠 Property Saver</a>
        <a href="calculator.php" class="nav-link active">💰 Calculator</a>
    </div>

    <div id="alert" class="alert"></div>

    <div class="calculator-section">
        <div class="property-selector">
            <h3>Select Property or Enter Price Manually</h3>
            <div class="property-dropdown">
                <select id="propertySelect">
                    <option value="">Select a saved property...</option>
                </select>
                <span>OR</span>
                <div class="manual-input">
                    <label>Manual Price: €</label>
                    <input type="number" id="manualPrice" placeholder="495000" min="0" step="1000">
                    <button class="btn" onclick="useManualPrice()">Use This Price</button>
                </div>
            </div>
        </div>

        <div class="funds-section">
            <h3>Available Funds</h3>
            <div class="funds-input">
                <label>Total Available: €</label>
                <input type="number" id="availableFunds" value="557856" min="0" step="1000">
            </div>
        </div>

        <h3>Editable Costs</h3>
        <table class="costs-table">
            <thead>
            <tr>
                <th>Cost Item</th>
                <th>Vendor/Notes</th>
                <th>Amount (€)</th>
            </tr>
            </thead>
            <tbody>
            <tr class="category-header">
                <td colspan="3"><strong>PURCHASE COSTS</strong></td>
            </tr>
            <tr>
                <td>Stamp Duty (1%)</td>
                <td>Calculated automatically</td>
                <td><span id="stampDutyDisplay">€0.00</span></td>
            </tr>
            <tr>
                <td>Solicitors</td>
                <td><input type="text" value="Carey Solicitors" readonly style="background: #f8f9fa;"></td>
                <td><input type="number" id="solicitors" value="1900" step="0.01"></td>
            </tr>
            <tr>
                <td>Surveyor</td>
                <td><input type="text" value="PropertyHealthCheck.ie" readonly style="background: #f8f9fa;"></td>
                <td><input type="number" id="surveyor" value="734.31" step="0.01"></td>
            </tr>
            <tr>
                <td>Valuation</td>
                <td><input type="text" value="Ymsireland.ie" readonly style="background: #f8f9fa;"></td>
                <td><input type="number" id="valuation" value="185" step="0.01"></td>
            </tr>
            <tr>
                <td>Moving Van</td>
                <td><input type="text" value="vanrentals.ie" readonly style="background: #f8f9fa;"></td>
                <td><input type="number" id="movingVan" value="95" step="0.01"></td>
            </tr>
            <tr class="category-header">
                <td colspan="3"><strong>ONGOING COSTS</strong></td>
            </tr>
            <tr>
                <td>Mortgage Protection</td>
                <td><input type="text" value="Monthly - cheapest quote" readonly style="background: #f8f9fa;"></td>
                <td><input type="number" id="mortgageProtection" value="21.52" step="0.01"></td>
            </tr>
            <tr>
                <td>Life Insurance</td>
                <td><input type="text" value="Monthly - non-decreasing" readonly style="background: #f8f9fa;"></td>
                <td><input type="number" id="lifeInsurance" value="33.40" step="0.01"></td>
            </tr>
            <tr>
                <td>Home Insurance</td>
                <td><input type="text" value="Monthly payment" readonly style="background: #f8f9fa;"></td>
                <td><input type="number" id="homeInsurance" value="66.92" step="0.01"></td>
            </tr>
            <tr>
                <td>White Goods</td>
                <td><input type="text" value="Appliances" readonly style="background: #f8f9fa;"></td>
                <td><input type="number" id="whiteGoods" value="1509.80" step="0.01"></td>
            </tr>
            <tr>
                <td>Other Monthly Costs</td>
                <td><input type="text" value="Miscellaneous" readonly style="background: #f8f9fa;"></td>
                <td><input type="number" id="otherCosts" value="1287" step="0.01"></td>
            </tr>
            </tbody>
        </table>

        <button class="btn" onclick="calculateAll()" style="margin-bottom: 20px;">📊 Calculate All Scenarios</button>
    </div>

    <div class="scenarios-grid" id="scenariosGrid" style="display: none;">
        <!-- Scenarios will be populated here -->
    </div>
</div>

<script>
    let currentHousePrice = 0;
    let properties = [];

    function showAlert(message, type = 'success') {
        const alert = document.getElementById('alert');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;
        alert.style.display = 'block';
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    }

    async function loadProperties() {
        try {
            const response = await fetch('backend.php?endpoint=properties');
            const result = await response.json();

            if (result.success) {
                properties = result.data || [];
                populatePropertyDropdown();
            }
        } catch (error) {
            console.error('Error loading properties:', error);
        }
    }

    function populatePropertyDropdown() {
        const select = document.getElementById('propertySelect');
        select.innerHTML = '<option value="">Select a saved property...</option>';

        properties.forEach(property => {
            const option = document.createElement('option');
            option.value = property.id;
            option.textContent = `${property.title || 'Property'} - ${property.price || 'No price'}`;
            option.dataset.price = extractPrice(property.price);
            select.appendChild(option);
        });
    }

    function extractPrice(priceString) {
        if (!priceString) return 0;
        // Extract numbers from price string (e.g., "€495,000" -> 495000)
        const numbers = priceString.replace(/[^\d]/g, '');
        return parseInt(numbers) || 0;
    }

    function useManualPrice() {
        const price = parseFloat(document.getElementById('manualPrice').value) || 0;
        if (price > 0) {
            currentHousePrice = price;
            document.getElementById('propertySelect').value = '';
            calculateAll();
            showAlert(`Using manual price: €${price.toLocaleString()}`);
        } else {
            showAlert('Please enter a valid price', 'error');
        }
    }

    function calculateStampDuty(housePrice) {
        return housePrice * 0.01;
    }

    function getAllCosts() {
        return {
            solicitors: parseFloat(document.getElementById('solicitors').value) || 0,
            surveyor: parseFloat(document.getElementById('surveyor').value) || 0,
            valuation: parseFloat(document.getElementById('valuation').value) || 0,
            movingVan: parseFloat(document.getElementById('movingVan').value) || 0,
            mortgageProtection: parseFloat(document.getElementById('mortgageProtection').value) || 0,
            lifeInsurance: parseFloat(document.getElementById('lifeInsurance').value) || 0,
            homeInsurance: parseFloat(document.getElementById('homeInsurance').value) || 0,
            whiteGoods: parseFloat(document.getElementById('whiteGoods').value) || 0,
            otherCosts: parseFloat(document.getElementById('otherCosts').value) || 0
        };
    }

    function calculateScenario(housePrice, multiplier, scenarioName) {
        const adjustedPrice = housePrice * multiplier;
        const stampDuty = calculateStampDuty(adjustedPrice);
        const costs = getAllCosts();
        const totalOtherCosts = Object.values(costs).reduce((sum, cost) => sum + cost, 0);
        const totalCost = adjustedPrice + stampDuty + totalOtherCosts;
        const availableFunds = parseFloat(document.getElementById('availableFunds').value) || 0;
        const remainingMoney = availableFunds - totalCost;

        return {
            scenarioName,
            housePrice: adjustedPrice,
            stampDuty,
            costs,
            totalOtherCosts,
            totalCost,
            remainingMoney,
            multiplierText: multiplier === 1 ? 'Asking Price' : `${((multiplier - 1) * 100).toFixed(0)}% Over Asking`
        };
    }

    function renderScenario(scenario, className) {
        return `
                <div class="scenario-card ${className}">
                    <div class="scenario-title">${scenario.multiplierText}</div>

                    <div class="cost-breakdown">
                        <div class="cost-item">
                            <span class="cost-label">House Price:</span>
                            <span class="cost-value house-price">€${scenario.housePrice.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Stamp Duty (1%):</span>
                            <span class="cost-value">€${scenario.stampDuty.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Solicitors:</span>
                            <span class="cost-value">€${scenario.costs.solicitors.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Surveyor:</span>
                            <span class="cost-value">€${scenario.costs.surveyor.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Valuation:</span>
                            <span class="cost-value">€${scenario.costs.valuation.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Moving Van:</span>
                            <span class="cost-value">€${scenario.costs.movingVan.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Insurance & Ongoing:</span>
                            <span class="cost-value">€${(scenario.costs.mortgageProtection + scenario.costs.lifeInsurance + scenario.costs.homeInsurance).toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">White Goods:</span>
                            <span class="cost-value">€${scenario.costs.whiteGoods.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Other Costs:</span>
                            <span class="cost-value">€${scenario.costs.otherCosts.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                    </div>

                    <div class="total-cost">
                        <div class="cost-item">
                            <span class="cost-label">TOTAL COST:</span>
                            <span class="cost-value">€${scenario.totalCost.toLocaleString('en-IE', {minimumFractionDigits: 2})}</span>
                        </div>
                    </div>

                    <div class="remaining-money ${scenario.remainingMoney < 0 ? 'negative' : ''}">
                        <div class="remaining-amount">€${Math.abs(scenario.remainingMoney).toLocaleString('en-IE', {minimumFractionDigits: 2})}</div>
                        <div class="remaining-label">${scenario.remainingMoney >= 0 ? 'Remaining' : 'Shortfall'}</div>
                    </div>
                </div>
            `;
    }

    function calculateAll() {
        if (currentHousePrice <= 0) {
            showAlert('Please select a property or enter a manual price first', 'error');
            return;
        }

        // Update stamp duty display
        const stampDuty = calculateStampDuty(currentHousePrice);
        document.getElementById('stampDutyDisplay').textContent = `€${stampDuty.toLocaleString('en-IE', {minimumFractionDigits: 2})}`;

        // Calculate all scenarios
        const askingScenario = calculateScenario(currentHousePrice, 1, 'asking');
        const over10Scenario = calculateScenario(currentHousePrice, 1.10, '10over');
        const over15Scenario = calculateScenario(currentHousePrice, 1.15, '15over');

        // Render scenarios
        const grid = document.getElementById('scenariosGrid');
        grid.innerHTML = `
                ${renderScenario(askingScenario, 'scenario-asking')}
                ${renderScenario(over10Scenario, 'scenario-10')}
                ${renderScenario(over15Scenario, 'scenario-15')}
            `;

        grid.style.display = 'grid';
        showAlert('Calculations updated successfully!');
    }

    // Event listeners
    document.getElementById('propertySelect').addEventListener('change', function() {
        if (this.value) {
            const price = parseFloat(this.dataset.price || this.options[this.selectedIndex].dataset.price);
            if (price > 0) {
                currentHousePrice = price;
                document.getElementById('manualPrice').value = '';
                calculateAll();
            } else {
                showAlert('Selected property has no valid price', 'error');
            }
        }
    });

    // Auto-calculate when any cost input changes
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', () => {
            if (currentHousePrice > 0) {
                calculateAll();
            }
        });
    });

    // Initialize
    loadProperties();
</script>
</body>
</html>