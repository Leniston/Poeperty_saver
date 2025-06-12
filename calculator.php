<?php include 'header.php'; ?>

    <!-- Page-specific mobile-friendly styles for calculator -->
    <style>
        .property-selector {
            margin-bottom: 25px;
        }

        .property-selector h3 {
            margin-bottom: 15px;
            color: #333;
            font-size: 1.1rem;
        }

        .property-dropdown {
            display: flex;
            gap: 12px;
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
            min-height: 44px;
        }

        .manual-input {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .manual-input input {
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            background: #f8f9fa;
            width: 140px;
            min-height: 44px;
        }

        .funds-section {
            background: #e8f4fd;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .funds-section h3 {
            margin-bottom: 15px;
            color: #333;
            font-size: 1.1rem;
        }

        .funds-input {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .funds-input input {
            padding: 12px 15px;
            border: 2px solid #667eea;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            width: 180px;
            background: white;
            min-height: 44px;
        }

        .costs-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            font-size: 0.9rem;
        }

        .costs-table th,
        .costs-table td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .costs-table th {
            background: #667eea;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .costs-table input {
            border: 1px solid #ddd;
            padding: 8px 6px;
            border-radius: 4px;
            width: 100%;
            text-align: right;
            font-size: 0.9rem;
            min-height: 36px;
        }

        .category-header {
            background: #f8f9fa !important;
            font-weight: bold;
            color: #333 !important;
        }

        .scenarios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .scenario-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-top: 5px solid;
            transition: transform 0.3s ease;
        }

        .scenario-card:hover {
            transform: translateY(-3px);
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
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .cost-breakdown {
            margin-bottom: 15px;
        }

        .cost-item {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
        }

        .cost-item:last-child {
            border-bottom: none;
        }

        .cost-label {
            color: #666;
            flex: 1;
        }

        .cost-value {
            font-weight: 600;
            color: #333;
            text-align: right;
        }

        .house-price {
            font-size: 1.1rem;
            color: #667eea;
            font-weight: bold;
        }

        .total-cost {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            margin: 12px 0;
        }

        .total-cost .cost-item {
            font-size: 1rem;
            font-weight: bold;
            border-bottom: none;
        }

        .remaining-money {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .remaining-money.negative {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .remaining-amount {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .remaining-label {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .property-dropdown {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .property-dropdown select {
                min-width: auto;
                width: 100%;
            }

            .manual-input {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .manual-input input {
                width: 100%;
            }

            .funds-input {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .funds-input input {
                width: 100%;
            }

            .scenarios-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .scenario-card {
                padding: 15px;
            }

            .scenario-title {
                font-size: 1.2rem;
            }

            .costs-table {
                font-size: 0.8rem;
            }

            .costs-table th,
            .costs-table td {
                padding: 8px 6px;
            }

            .costs-table th {
                font-size: 0.75rem;
            }

            /* Make table horizontally scrollable on very small screens */
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .remaining-amount {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .scenario-card {
                padding: 12px;
            }

            .cost-item {
                font-size: 0.85rem;
                padding: 4px 0;
            }

            .costs-table {
                font-size: 0.75rem;
            }

            .costs-table th,
            .costs-table td {
                padding: 6px 4px;
            }

            .funds-section,
            .property-selector {
                padding: 15px;
            }
        }
    </style>

    <div class="content-section">
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
        <div class="table-container">
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
                    <td><input type="text" value="Carey Solicitors" readonly style="background: #f8f9fa; font-size: 0.8rem;"></td>
                    <td><input type="number" id="solicitors" value="1900" step="0.01"></td>
                </tr>
                <tr>
                    <td>Surveyor</td>
                    <td><input type="text" value="PropertyHealthCheck.ie" readonly style="background: #f8f9fa; font-size: 0.8rem;"></td>
                    <td><input type="number" id="surveyor" value="734.31" step="0.01"></td>
                </tr>
                <tr>
                    <td>Valuation</td>
                    <td><input type="text" value="Ymsireland.ie" readonly style="background: #f8f9fa; font-size: 0.8rem;"></td>
                    <td><input type="number" id="valuation" value="185" step="0.01"></td>
                </tr>
                <tr>
                    <td>Moving Van</td>
                    <td><input type="text" value="vanrentals.ie" readonly style="background: #f8f9fa; font-size: 0.8rem;"></td>
                    <td><input type="number" id="movingVan" value="95" step="0.01"></td>
                </tr>
                <tr class="category-header">
                    <td colspan="3"><strong>ONGOING COSTS</strong></td>
                </tr>
                <tr>
                    <td>Mortgage Protection</td>
                    <td><input type="text" value="Monthly - cheapest quote" readonly style="background: #f8f9fa; font-size: 0.8rem;"></td>
                    <td><input type="number" id="mortgageProtection" value="21.52" step="0.01"></td>
                </tr>
                <tr>
                    <td>Life Insurance</td>
                    <td><input type="text" value="Monthly - non-decreasing" readonly style="background: #f8f9fa; font-size: 0.8rem;"></td>
                    <td><input type="number" id="lifeInsurance" value="33.40" step="0.01"></td>
                </tr>
                <tr>
                    <td>Home Insurance</td>
                    <td><input type="text" value="Monthly payment" readonly style="background: #f8f9fa; font-size: 0.8rem;"></td>
                    <td><input type="number" id="homeInsurance" value="66.92" step="0.01"></td>
                </tr>
                <tr>
                    <td>White Goods</td>
                    <td><input type="text" value="Appliances" readonly style="background: #f8f9fa; font-size: 0.8rem;"></td>
                    <td><input type="number" id="whiteGoods" value="1509.80" step="0.01"></td>
                </tr>
                <tr>
                    <td>Other Monthly Costs</td>
                    <td><input type="text" value="Miscellaneous" readonly style="background: #f8f9fa; font-size: 0.8rem;"></td>
                    <td><input type="number" id="otherCosts" value="1287" step="0.01"></td>
                </tr>
                </tbody>
            </table>
        </div>

        <button class="btn" onclick="calculateAll()" style="margin-bottom: 20px;">📊 Calculate All Scenarios</button>
    </div>

    <div class="scenarios-grid" id="scenariosGrid" style="display: none;">
        <!-- Scenarios will be populated here -->
    </div>

    <script>
        let currentHousePrice = 0;
        let properties = [];

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
                        <span class="cost-value house-price">€${scenario.housePrice.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label">Stamp Duty (1%):</span>
                        <span class="cost-value">€${scenario.stampDuty.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label">Solicitors:</span>
                        <span class="cost-value">€${scenario.costs.solicitors.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label">Surveyor:</span>
                        <span class="cost-value">€${scenario.costs.surveyor.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label">Other Costs:</span>
                        <span class="cost-value">€${(scenario.costs.valuation + scenario.costs.movingVan + scenario.costs.whiteGoods + scenario.costs.otherCosts).toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                    </div>
                    <div class="cost-item">
                        <span class="cost-label">Insurance:</span>
                        <span class="cost-value">€${(scenario.costs.mortgageProtection + scenario.costs.lifeInsurance + scenario.costs.homeInsurance).toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                    </div>
                </div>

                <div class="total-cost">
                    <div class="cost-item">
                        <span class="cost-label">TOTAL COST:</span>
                        <span class="cost-value">€${scenario.totalCost.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                    </div>
                </div>

                <div class="remaining-money ${scenario.remainingMoney < 0 ? 'negative' : ''}">
                    <div class="remaining-amount">€${Math.abs(scenario.remainingMoney).toLocaleString('en-IE', {minimumFractionDigits: 0})}</div>
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
            document.getElementById('stampDutyDisplay').textContent = `€${stampDuty.toLocaleString('en-IE', {minimumFractionDigits: 0})}`;

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

<?php include 'footer.php'; ?>