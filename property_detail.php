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
        let mapLoaded = false;

        // Get property ID from URL parameter
        function getPropertyId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id');
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
            const mapHtml = `
            <iframe
                width="100%"
                height="100%"
                frameborder="0"
                style="border:0"
                src="https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=${encodedAddress}&zoom=15"
                allowfullscreen>
            </iframe>
        `;

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
                const availableFunds = 557856; // Default from calculator
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

        // Initialize page
        document.addEventListener('DOMContentLoaded', loadPropertyData);
    </script>

<?php include 'footer.php'; ?>