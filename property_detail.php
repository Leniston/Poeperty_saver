<?php include 'header.php'; ?>

    <style>
        .property-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .property-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .property-meta {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .property-price {
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 1.3rem;
            font-weight: bold;
        }

        .property-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-interested { background: rgba(40, 167, 69, 0.2); }
        .status-viewing { background: rgba(255, 193, 7, 0.2); }
        .status-offer { background: rgba(0, 123, 255, 0.2); }
        .status-rejected { background: rgba(220, 53, 69, 0.2); }

        .property-image {
            width: 100%;
            max-width: 400px;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 15px;
        }

        .detail-sections {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .detail-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Funds Section Styles */
        .funds-section {
            background: #e8f4fd;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            border: 2px solid #667eea;
        }

        .funds-section h4 {
            margin-bottom: 20px;
            color: #333;
            font-size: 1.2rem;
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
            display: none;
        }

        .total-funds {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-top: 20px;
        }

        .total-amount {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .total-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        .funds-saved-indicator {
            background: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 0.9rem;
            border: 1px solid #c3e6cb;
        }

        .map-container {
            width: 100%;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #e9ecef;
        }

        .scenarios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .scenario-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 5px solid;
            transition: transform 0.3s ease;
        }

        .scenario-card:hover {
            transform: translateY(-3px);
        }

        .scenario-asking { border-left-color: #28a745; }
        .scenario-10 { border-left-color: #ffc107; }
        .scenario-15 { border-left-color: #dc3545; }

        .scenario-title {
            font-size: 1.2rem;
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
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .remaining-label {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .distance-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .distance-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .distance-destination {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

        .distance-time {
            color: #28a745;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .area-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .area-category {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid;
        }

        .category-education { border-left-color: #007bff; }
        .category-shopping { border-left-color: #28a745; }
        .category-transport { border-left-color: #ffc107; }
        .category-healthcare { border-left-color: #dc3545; }
        .category-recreation { border-left-color: #6f42c1; }
        .category-safety { border-left-color: #fd7e14; }

        .category-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .amenity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .amenity-item {
            padding: 6px 0;
            color: #666;
            font-size: 0.9rem;
            border-bottom: 1px solid #e9ecef;
        }

        .amenity-item:last-child {
            border-bottom: none;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
            text-decoration: none;
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-button:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            text-decoration: none;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        @media (max-width: 768px) {
            .property-title {
                font-size: 1.6rem;
            }

            .property-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .scenarios-grid {
                grid-template-columns: 1fr;
            }

            .distance-grid {
                grid-template-columns: 1fr;
            }

            .area-categories {
                grid-template-columns: 1fr;
            }

            .detail-section {
                padding: 20px;
            }

            .map-container {
                height: 300px;
            }

            .funds-grid {
                grid-template-columns: 1fr;
            }

            .funds-section {
                padding: 20px;
            }
        }
    </style>

    <div class="property-header">
        <a href="index.php" class="back-button">← Back to Properties</a>

        <div class="property-title" id="propertyTitle">Loading property details...</div>

        <div class="property-meta">
            <div class="property-price" id="propertyPrice">€0</div>
            <div class="property-status" id="propertyStatus">Loading...</div>
        </div>

        <div id="propertyNotes" style="margin-top: 15px; opacity: 0.9;"></div>

        <img id="propertyImage" class="property-image" style="display: none;" alt="Property image">
    </div>

    <div class="detail-sections">
        <!-- Google Maps Section -->
        <div class="detail-section">
            <div class="section-title">
                🗺️ Location & Map
            </div>
            <div id="mapContainer" class="map-container">
                <div class="loading">Loading map...</div>
            </div>
        </div>

        <!-- Financial Analysis Section -->
        <div class="detail-section">
            <div class="section-title">
                💰 Financial Analysis
            </div>
            <p style="color: #666; margin-bottom: 20px;">Cost breakdown for different purchase scenarios</p>

            <div class="funds-section">
                <div id="fundsLoadedIndicator" class="funds-saved-indicator" style="display: none;">
                    ✅ Using your saved funds from the calculator
                </div>

                <h4>💰 Your Available Funds</h4>
                <div class="funds-grid">
                    <div class="fund-item">
                        <label for="detailSavingsFunds" class="fund-label">💰 Cash Savings</label>
                        <input type="number" id="detailSavingsFunds" class="fund-input" value="0" min="0" step="1000" placeholder="40000">
                    </div>

                    <div class="fund-item">
                        <label for="detailMortgageFunds" class="fund-label">💳 Mortgage Amount</label>
                        <input type="number" id="detailMortgageFunds" class="fund-input" value="0" min="0" step="1000" placeholder="350000">
                    </div>

                    <div class="fund-item">
                        <label for="detailInheritanceFunds" class="fund-label">🏠 Inheritance (House Sale Price)</label>
                        <input type="number" id="detailInheritanceFunds" class="fund-input" value="0" min="0" step="1000" placeholder="370000">
                        <div class="inheritance-note">
                            <strong>Note:</strong> Your 50% share calculated automatically<br>
                            • Estate Agent Fee: 1.25% of sale price<br>
                            • Solicitor Costs: €2,000 fixed fee
                        </div>
                        <div id="detailInheritanceCalculation" class="inheritance-calculation">
                            <!-- Calculation details will appear here -->
                        </div>
                    </div>
                </div>

                <div class="total-funds">
                    <div class="total-amount" id="detailTotalFundsDisplay">€0</div>
                    <div class="total-label">Total Available Funds</div>
                </div>
            </div>

            <div class="scenarios-grid" id="financialScenarios">
                <div class="loading">Calculating financial scenarios...</div>
            </div>
        </div>

        <!-- Distance Analysis Section -->
        <div class="detail-section">
            <div class="section-title">
                📏 Distance to Key Locations
            </div>
            <p style="color: #666; margin-bottom: 20px;">Travel times to your important locations</p>

            <div class="distance-grid" id="distanceAnalysis">
                <div class="loading">Analyzing travel times...</div>
            </div>
        </div>

        <!-- Area Information Section -->
        <div class="detail-section">
            <div class="section-title">
                🏘️ Local Area Information
            </div>
            <p style="color: #666; margin-bottom: 20px;">Amenities and services in the area</p>

            <div class="area-categories" id="areaInformation">
                <div class="loading">Loading area information...</div>
            </div>
        </div>
    </div>

    <script>
        let propertyId = null;
        let propertyData = null;
        let fundsLoaded = false;

        // Get property ID from URL parameter
        function getPropertyId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id');
        }

        // Try to load funds from localStorage (saved from calculator/mortgage pages)
        function loadSavedFunds() {
            try {
                const savedFunds = {
                    savings: localStorage.getItem('calculator_savings') || localStorage.getItem('mortgage_savings'),
                    mortgage: localStorage.getItem('calculator_mortgage') || localStorage.getItem('mortgage_amount'),
                    inheritance: localStorage.getItem('calculator_inheritance') || localStorage.getItem('mortgage_inheritance')
                };

                let hasData = false;

                if (savedFunds.savings && parseFloat(savedFunds.savings) > 0) {
                    document.getElementById('detailSavingsFunds').value = savedFunds.savings;
                    hasData = true;
                }

                if (savedFunds.mortgage && parseFloat(savedFunds.mortgage) > 0) {
                    document.getElementById('detailMortgageFunds').value = savedFunds.mortgage;
                    hasData = true;
                }

                if (savedFunds.inheritance && parseFloat(savedFunds.inheritance) > 0) {
                    document.getElementById('detailInheritanceFunds').value = savedFunds.inheritance;
                    hasData = true;
                }

                if (hasData) {
                    fundsLoaded = true;
                    document.getElementById('fundsLoadedIndicator').style.display = 'block';
                }

                updateDetailFunds();
                return hasData;
            } catch (error) {
                console.log('No saved funds found or localStorage not available');
                return false;
            }
        }

        // Save current funds to localStorage for other pages
        function saveFundsToStorage() {
            try {
                const savings = document.getElementById('detailSavingsFunds').value;
                const mortgage = document.getElementById('detailMortgageFunds').value;
                const inheritance = document.getElementById('detailInheritanceFunds').value;

                localStorage.setItem('detail_savings', savings);
                localStorage.setItem('detail_mortgage', mortgage);
                localStorage.setItem('detail_inheritance', inheritance);
            } catch (error) {
                console.log('Could not save to localStorage');
            }
        }

        function calculateDetailInheritance() {
            const houseSalePrice = parseFloat(document.getElementById('detailInheritanceFunds').value) || 0;
            const calculationDiv = document.getElementById('detailInheritanceCalculation');

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

        function updateDetailFunds() {
            const savings = parseFloat(document.getElementById('detailSavingsFunds').value) || 0;
            const mortgage = parseFloat(document.getElementById('detailMortgageFunds').value) || 0;
            const netInheritance = calculateDetailInheritance();

            const totalAvailable = savings + mortgage + netInheritance;

            document.getElementById('detailTotalFundsDisplay').textContent =
                `€${totalAvailable.toLocaleString('en-IE', {minimumFractionDigits: 0})}`;

            // Save to localStorage for other pages
            saveFundsToStorage();

            // Recalculate financial scenarios if property data is available
            if (propertyData) {
                calculateFinancialScenarios(propertyData);
            }

            return totalAvailable;
        }

        // Load property data
        async function loadPropertyData() {
            propertyId = getPropertyId();

            if (!propertyId) {
                showAlert('No property ID provided', 'error');
                return;
            }

            try {
                // Get property details from backend
                const response = await fetch(`backend.php?endpoint=properties`);
                const result = await response.json();

                if (result.success) {
                    const property = result.data.find(p => p.id == propertyId);

                    if (property) {
                        propertyData = property;
                        displayPropertyInfo(property);
                        await loadGoogleMap(property);
                        await calculateFinancialScenarios(property);
                        await analyzeDistances(property);
                        await loadAreaInformation(property);
                    } else {
                        showAlert('Property not found', 'error');
                    }
                }
            } catch (error) {
                console.error('Error loading property:', error);
                showAlert('Error loading property details', 'error');
            }
        }

        function displayPropertyInfo(property) {
            document.getElementById('propertyTitle').textContent = property.title || 'Property Details';
            document.getElementById('propertyPrice').textContent = property.price || 'Price not available';

            const statusElement = document.getElementById('propertyStatus');
            statusElement.textContent = property.status.charAt(0).toUpperCase() + property.status.slice(1);
            statusElement.className = `property-status status-${property.status}`;

            if (property.notes) {
                const cleanNotes = cleanNotesForDisplay(property.notes);
                if (cleanNotes) {
                    document.getElementById('propertyNotes').textContent = cleanNotes;
                }

                // Show property image if available
                const imageUrl = extractImageFromNotes(property.notes);
                if (imageUrl) {
                    const img = document.getElementById('propertyImage');
                    img.src = imageUrl;
                    img.style.display = 'block';
                    img.onerror = () => img.style.display = 'none';
                }
            }
        }

        async function loadGoogleMap(property) {
            const address = extractAddressFromProperty(property);

            if (!address) {
                document.getElementById('mapContainer').innerHTML =
                    '<div class="error">Unable to determine property address for map display</div>';
                return;
            }

            // Create Google Maps embed
            const encodedAddress = encodeURIComponent(address + ', Ireland');

            // For demo without API key, use alternative
            const alternativeMapHtml = `
            <iframe
                width="100%"
                height="100%"
                frameborder="0"
                style="border:0"
                src="https://maps.google.com/maps?q=${encodedAddress}&output=embed"
                allowfullscreen>
            </iframe>
        `;

            document.getElementById('mapContainer').innerHTML = alternativeMapHtml;
        }

        async function calculateFinancialScenarios(property) {
            const price = extractPrice(property.price);

            if (!price) {
                document.getElementById('financialScenarios').innerHTML =
                    '<div class="error">Unable to calculate financial scenarios - price not available</div>';
                return;
            }

            // Get current available funds
            const availableFunds = updateDetailFunds();

            // Use the same calculation logic as calculator.php
            const scenarios = [
                { multiplier: 1.0, name: 'Asking Price', class: 'scenario-asking' },
                { multiplier: 1.10, name: '10% Over Asking', class: 'scenario-10' },
                { multiplier: 1.15, name: '15% Over Asking', class: 'scenario-15' }
            ];

            let scenariosHtml = '';

            scenarios.forEach(scenario => {
                const adjustedPrice = price * scenario.multiplier;
                const stampDuty = adjustedPrice * 0.01;
                const otherCosts = 1900 + 734.31 + 185 + 95 + 21.52 + 33.40 + 66.92 + 1509.80 + 1287; // Sum of all costs
                const totalCost = adjustedPrice + stampDuty + otherCosts;
                const remainingMoney = availableFunds - totalCost;

                scenariosHtml += `
                <div class="scenario-card ${scenario.class}">
                    <div class="scenario-title">${scenario.name}</div>

                    <div class="cost-breakdown">
                        <div class="cost-item">
                            <span class="cost-label">House Price:</span>
                            <span class="cost-value house-price">€${adjustedPrice.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Stamp Duty (1%):</span>
                            <span class="cost-value">€${stampDuty.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Other Costs:</span>
                            <span class="cost-value">€${otherCosts.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                        </div>
                    </div>

                    <div class="total-cost">
                        <div class="cost-item">
                            <span class="cost-label">TOTAL COST:</span>
                            <span class="cost-value">€${totalCost.toLocaleString('en-IE', {minimumFractionDigits: 0})}</span>
                        </div>
                    </div>

                    <div class="remaining-money ${remainingMoney < 0 ? 'negative' : ''}">
                        <div class="remaining-amount">€${Math.abs(remainingMoney).toLocaleString('en-IE', {minimumFractionDigits: 0})}</div>
                        <div class="remaining-label">${remainingMoney >= 0 ? 'Remaining' : 'Shortfall'}</div>
                    </div>
                </div>
            `;
            });

            document.getElementById('financialScenarios').innerHTML = scenariosHtml;
        }

        async function analyzeDistances(property) {
            const address = extractAddressFromProperty(property);

            if (!address) {
                document.getElementById('distanceAnalysis').innerHTML =
                    '<div class="error">Unable to analyze distances - address not available</div>';
                return;
            }

            try {
                const response = await fetch('location_analyzer_backend.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        property_address: address,
                        locations: [
                            'Beaumont Hospital, Dublin',
                            'Kildare County Council, Naas',
                            'Wood Avens, Clondalkin',
                            'Allen View Heights, Newbridge',
                            'Royal Oak, Enfield'
                        ]
                    })
                });

                const result = await response.json();

                if (result.success) {
                    displayDistanceResults(result.data);
                } else {
                    document.getElementById('distanceAnalysis').innerHTML =
                        '<div class="error">Unable to calculate distances: ' + result.error + '</div>';
                }
            } catch (error) {
                console.error('Distance analysis error:', error);
                document.getElementById('distanceAnalysis').innerHTML =
                    '<div class="error">Error calculating travel times</div>';
            }
        }

        function displayDistanceResults(distanceData) {
            const grouped = {};
            distanceData.forEach(item => {
                if (!grouped[item.destination]) {
                    grouped[item.destination] = {};
                }
                grouped[item.destination][item.travel_mode] = item;
            });

            let html = '';
            Object.keys(grouped).forEach(destination => {
                const driving = grouped[destination]['driving'];
                if (driving) {
                    html += `
                    <div class="distance-card">
                        <div class="distance-destination">${destination}</div>
                        <div class="distance-time">🚗 ${driving.duration} (${driving.distance})</div>
                    </div>
                `;
                }
            });

            document.getElementById('distanceAnalysis').innerHTML = html || '<div class="error">No distance data available</div>';
        }

        async function loadAreaInformation(property) {
            const area = extractAreaFromProperty(property);

            if (!area) {
                document.getElementById('areaInformation').innerHTML =
                    '<div class="error">Unable to determine area for local information</div>';
                return;
            }

            try {
                const response = await fetch('area_checker_backend.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ area: area })
                });

                const result = await response.json();

                if (result.success) {
                    displayAreaInformation(result.data);
                } else {
                    document.getElementById('areaInformation').innerHTML =
                        '<div class="error">Unable to load area information: ' + result.error + '</div>';
                }
            } catch (error) {
                console.error('Area information error:', error);
                document.getElementById('areaInformation').innerHTML =
                    '<div class="error">Error loading area information</div>';
            }
        }

        function displayAreaInformation(areaData) {
            const categories = [
                { key: 'education', icon: '🎓', title: 'Education', class: 'category-education' },
                { key: 'shopping', icon: '🛒', title: 'Shopping', class: 'category-shopping' },
                { key: 'transport', icon: '🚌', title: 'Transport', class: 'category-transport' },
                { key: 'healthcare', icon: '🏥', title: 'Healthcare', class: 'category-healthcare' },
                { key: 'recreation', icon: '⚽', title: 'Recreation', class: 'category-recreation' },
                { key: 'safety', icon: '🛡️', title: 'Safety', class: 'category-safety' }
            ];

            let html = '';

            categories.forEach(category => {
                const items = areaData[category.key] || [];

                html += `
                <div class="area-category ${category.class}">
                    <div class="category-title">
                        ${category.icon} ${category.title}
                    </div>
                    <ul class="amenity-list">
            `;

                if (items.length > 0) {
                    items.slice(0, 5).forEach(item => {
                        html += `<li class="amenity-item">${item.name}</li>`;
                    });
                } else {
                    html += `<li class="amenity-item">No information available</li>`;
                }

                html += `
                    </ul>
                </div>
            `;
            });

            document.getElementById('areaInformation').innerHTML = html;
        }

        // Helper functions
        function extractPrice(priceString) {
            if (!priceString) return 0;
            const numbers = priceString.replace(/[^\d]/g, '');
            return parseInt(numbers) || 0;
        }

        function extractAddressFromProperty(property) {
            // Try to extract address from title or notes
            if (property.title) {
                return property.title.replace(/^\d+\s*bed\s*/i, '').trim();
            }
            return property.url ? property.url.split('/').pop().replace(/-/g, ' ') : null;
        }

        function extractAreaFromProperty(property) {
            // Try to extract area name from property data
            const title = property.title || '';
            const areas = ['Clondalkin', 'Dublin 15', 'Naas', 'Newbridge', 'Swords', 'Enfield'];

            for (const area of areas) {
                if (title.toLowerCase().includes(area.toLowerCase())) {
                    return area;
                }
            }

            // Fallback: try to extract from URL or use a default
            return 'Dublin';
        }

        function extractImageFromNotes(notes) {
            if (!notes) return null;
            const imageMatch = notes.match(/Image:\s*(https?:\/\/[^\s|]+)/);
            return imageMatch ? imageMatch[1] : null;
        }

        function cleanNotesForDisplay(notes) {
            if (!notes) return '';
            return notes.replace(/\s*\|\s*Image:\s*https?:\/\/[^\s|]+/g, '').trim();
        }

        // Event listeners for fund inputs
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to fund inputs
            document.querySelectorAll('#detailSavingsFunds, #detailMortgageFunds, #detailInheritanceFunds').forEach(input => {
                input.addEventListener('input', updateDetailFunds);
            });

            // Try to load saved funds first
            if (!loadSavedFunds()) {
                // If no saved funds, set some default values to show how it works
                document.getElementById('detailSavingsFunds').value = 40000;
                document.getElementById('detailMortgageFunds').value = 350000;
                document.getElementById('detailInheritanceFunds').value = 370000;
                updateDetailFunds();
            }

            // Load property data
            loadPropertyData();
        });
    </script>

<?php include 'footer.php'; ?>