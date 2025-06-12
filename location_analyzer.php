<?php include 'header.php'; ?>

    <style>
        .location-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
        }

        .results-container {
            display: none;
            margin-top: 30px;
        }

        .property-info {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .property-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .property-address {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .property-image {
            width: 100%;
            max-width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 15px;
        }

        .distance-results {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .distance-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #667eea;
            transition: transform 0.3s ease;
        }

        .distance-card:hover {
            transform: translateY(-5px);
        }

        .location-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .transport-modes {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .mode-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #e9ecef;
        }

        .mode-icon {
            font-size: 1.5rem;
            margin-bottom: 8px;
        }

        .mode-name {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 8px;
            text-transform: capitalize;
        }

        .mode-distance {
            font-weight: bold;
            color: #667eea;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .mode-time {
            font-weight: 600;
            color: #28a745;
            font-size: 1rem;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.1rem;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .default-locations {
            background: #e8f4fd;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .location-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .location-item {
            background: white;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            text-align: center;
            border: 2px solid #667eea;
        }

        .property-selector {
            margin-bottom: 20px;
        }

        .property-dropdown {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .property-dropdown select {
            min-width: 300px;
        }

        @media (max-width: 768px) {
            .transport-modes {
                grid-template-columns: 1fr;
            }

            .distance-results {
                grid-template-columns: 1fr;
            }

            .property-dropdown {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>

    <div class="content-section">
        <h2 style="margin-bottom: 25px; color: #333;">🗺️ Property Location Analyzer</h2>
        <p style="color: #666; margin-bottom: 25px;">Automatically analyze travel times to your key locations</p>

        <div class="location-form">
            <div class="default-locations">
                <h4 style="margin-bottom: 10px;">📍 Analyzing Travel Times To:</h4>
                <div class="location-list">
                    <div class="location-item">🏥 Beaumont Hospital</div>
                    <div class="location-item">🏛️ Kildare County Council, Naas</div>
                    <div class="location-item">🏠 Wood Avens, Clondalkin</div>
                    <div class="location-item">🏠 Allen View Heights, Newbridge</div>
                    <div class="location-item">🏠 Royal Oak, Enfield</div>
                </div>
                <p style="margin-top: 10px; font-size: 0.9rem; color: #666;">
                    🚗 Driving • 🏍️ Motorcycle • 🚌 Public Transport
                </p>
            </div>

            <div class="property-selector">
                <label>Choose Property Source:</label>
                <div class="property-dropdown">
                    <select id="propertySelect">
                        <option value="">Select a saved property...</option>
                    </select>
                    <span>OR</span>
                    <input type="url" id="propertyUrl" placeholder="https://www.daft.ie/for-sale/..." style="flex: 1; min-width: 300px;">
                </div>
            </div>

            <button class="btn" onclick="analyzeLocation()" style="width: 100%; margin-top: 20px;">
                🔍 Analyze Travel Times (FREE)
            </button>
        </div>
    </div>

    <div class="results-container" id="resultsContainer">
        <!-- Results will be populated here -->
    </div>

    <script>
        let properties = [];

        // Load saved properties
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
                option.value = property.url;
                option.textContent = `${property.title || 'Property'} - ${property.price || 'No price'}`;
                select.appendChild(option);
            });
        }

        // When property is selected from dropdown, fill URL field
        document.getElementById('propertySelect').addEventListener('change', function() {
            if (this.value) {
                document.getElementById('propertyUrl').value = this.value;
            }
        });

        async function analyzeLocation() {
            let propertyUrl = document.getElementById('propertyUrl').value.trim();

            // Get URL from dropdown if not manually entered
            if (!propertyUrl) {
                propertyUrl = document.getElementById('propertySelect').value;
            }

            if (!propertyUrl) {
                showAlert('Please enter a property URL or select a saved property', 'error');
                return;
            }

            // Default locations (always analyzed)
            const defaultLocations = [
                'Beaumont Hospital, Dublin',
                'Kildare County Council, Naas',
                'Wood Avens, Clondalkin',
                'Allen View Heights, Newbridge',
                'Royal Oak, Enfield'
            ];

            // Show loading
            const resultsContainer = document.getElementById('resultsContainer');
            resultsContainer.style.display = 'block';
            resultsContainer.innerHTML = `<div class="loading">🔍 Analyzing property and calculating travel times...<br><small>Checking ${defaultLocations.length} locations with 3 transport modes each</small></div>`;

            try {
                // Step 1: Scrape property information
                showAlert('Extracting property information...', 'info');
                const propertyResponse = await fetch('property_scraper.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ url: propertyUrl })
                });

                const propertyResult = await propertyResponse.json();

                if (!propertyResult.success) {
                    throw new Error('Could not extract property information: ' + propertyResult.error);
                }

                // Step 2: Calculate distances
                showAlert('Calculating travel times for all transport modes...', 'info');
                const distanceResponse = await fetch('location_analyzer_backend.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        property_address: propertyResult.data.address || propertyResult.data.title,
                        locations: defaultLocations
                    })
                });

                const distanceResult = await distanceResponse.json();

                if (!distanceResult.success) {
                    throw new Error('Could not calculate distances: ' + distanceResult.error);
                }

                // Display results
                displayResults(propertyResult.data, distanceResult.data);
                showAlert('Analysis complete! 🎉', 'success');

            } catch (error) {
                console.error('Analysis error:', error);
                resultsContainer.innerHTML = `<div class="error">Error: ${error.message}</div>`;
                showAlert('Analysis failed: ' + error.message, 'error');
            }
        }

        function displayResults(propertyData, distanceData) {
            const resultsContainer = document.getElementById('resultsContainer');

            // Property information
            let propertyHTML = `
            <div class="property-info">
                <div class="property-title">${propertyData.title || 'Property'}</div>
                <div class="property-address">📍 ${propertyData.address || 'Address not available'}</div>
                ${propertyData.price ? `<div style="font-size: 1.3rem; font-weight: bold; color: #28a745; margin: 10px 0;">${propertyData.price}</div>` : ''}
                ${propertyData.bedrooms || propertyData.bathrooms || propertyData.property_type ? `
                    <div style="color: #666; margin: 10px 0;">
                        ${propertyData.property_type || ''} ${propertyData.bedrooms || ''} ${propertyData.bathrooms || ''}
                    </div>
                ` : ''}
                ${propertyData.image_url ? `<img src="${propertyData.image_url}" class="property-image" alt="Property image">` : ''}
            </div>
        `;

            // Group results by destination
            const groupedResults = {};
            distanceData.forEach(result => {
                if (!groupedResults[result.destination]) {
                    groupedResults[result.destination] = {};
                }
                groupedResults[result.destination][result.travel_mode] = result;
            });

            // Distance results
            let distanceHTML = '<div class="distance-results">';

            Object.keys(groupedResults).forEach(destination => {
                const modes = groupedResults[destination];

                distanceHTML += `
                <div class="distance-card">
                    <div class="location-name">${destination}</div>

                    <div class="transport-modes">
                        ${generateModeBox(modes['driving'], '🚗', 'Driving')}
                        ${generateModeBox(modes['motorcycle'], '🏍️', 'Motorcycle')}
                        ${generateModeBox(modes['transit'], '🚌', 'Public Transport')}
                    </div>
                </div>
            `;
            });

            distanceHTML += '</div>';

            resultsContainer.innerHTML = propertyHTML + distanceHTML;
        }

        function generateModeBox(modeData, icon, name) {
            if (!modeData) {
                return `
                <div class="mode-box" style="opacity: 0.5;">
                    <div class="mode-icon">${icon}</div>
                    <div class="mode-name">${name}</div>
                    <div class="mode-distance">N/A</div>
                    <div class="mode-time">N/A</div>
                </div>
            `;
            }

            return `
            <div class="mode-box">
                <div class="mode-icon">${icon}</div>
                <div class="mode-name">${name}</div>
                <div class="mode-distance">${modeData.distance}</div>
                <div class="mode-time">${modeData.duration}</div>
            </div>
        `;
        }

        // Initialize
        loadProperties();
    </script>

<?php include 'footer.php'; ?>