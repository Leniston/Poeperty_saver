<?php include 'header.php'; ?>

    <style>
        .search-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .search-input-container {
            display: flex;
            gap: 15px;
            max-width: 600px;
            margin: 0 auto;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1.1rem;
            background: white;
            min-height: 50px;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-btn {
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 50px;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }

        .search-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
            display: none;
        }

        .results-container {
            display: none;
        }

        .area-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .area-name {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .area-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }

        .category-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 5px solid;
            transition: transform 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .category-education { border-left-color: #007bff; }
        .category-shopping { border-left-color: #28a745; }
        .category-transport { border-left-color: #ffc107; }
        .category-healthcare { border-left-color: #dc3545; }
        .category-recreation { border-left-color: #6f42c1; }
        .category-safety { border-left-color: #fd7e14; }

        .category-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8f9fa;
        }

        .category-icon {
            font-size: 2rem;
            margin-right: 15px;
        }

        .category-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #333;
        }

        .items-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .item {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-weight: 600;
            color: #333;
            flex: 1;
        }

        .item-details {
            font-size: 0.9rem;
            color: #666;
            margin-top: 3px;
        }

        .item-rating {
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-left: 10px;
        }

        .item-distance {
            font-size: 0.8rem;
            color: #666;
            margin-left: 10px;
        }

        .no-results {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }

        .search-suggestions {
            background: #e8f4fd;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .search-suggestions h4 {
            margin-bottom: 15px;
            color: #333;
        }

        .suggestion-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .suggestion-btn {
            background: white;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .suggestion-btn:hover {
            background: #667eea;
            color: white;
        }

        @media (max-width: 768px) {
            .search-input-container {
                flex-direction: column;
                gap: 10px;
            }

            .search-input, .search-btn {
                width: 100%;
            }

            .categories-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .category-card {
                padding: 20px;
            }

            .area-name {
                font-size: 1.6rem;
            }

            .search-section {
                padding: 20px;
            }
        }
    </style>

    <div class="content-section">
        <div class="search-section">
            <h2 style="margin-bottom: 20px; color: #333;">🏘️ Area Information Checker</h2>
            <p style="color: #666; margin-bottom: 25px;">Get comprehensive information about any area in Ireland</p>

            <div class="search-input-container">
                <input type="text" id="areaInput" class="search-input" placeholder="Enter area name (e.g., Clondalkin, Dublin 15, Naas...)" value="">
                <button class="search-btn" id="searchBtn" onclick="searchArea()">
                    🔍 Search Area
                </button>
            </div>

            <div class="search-suggestions">
                <h4>Popular Areas:</h4>
                <div class="suggestion-list">
                    <button class="suggestion-btn" onclick="searchSpecificArea('Clondalkin')">Clondalkin</button>
                    <button class="suggestion-btn" onclick="searchSpecificArea('Dublin 15')">Dublin 15</button>
                    <button class="suggestion-btn" onclick="searchSpecificArea('Naas')">Naas</button>
                    <button class="suggestion-btn" onclick="searchSpecificArea('Newbridge')">Newbridge</button>
                    <button class="suggestion-btn" onclick="searchSpecificArea('Enfield')">Enfield</button>
                    <button class="suggestion-btn" onclick="searchSpecificArea('Swords')">Swords</button>
                    <button class="suggestion-btn" onclick="searchSpecificArea('Maynooth')">Maynooth</button>
                    <button class="suggestion-btn" onclick="searchSpecificArea('Celbridge')">Celbridge</button>
                </div>
            </div>
        </div>
    </div>

    <div class="loading" id="loadingMessage">
        <h3>🔍 Searching for area information...</h3>
        <p>This may take a moment as we gather data from multiple sources</p>
    </div>

    <div class="results-container" id="resultsContainer">
        <!-- Results will be populated here -->
    </div>

    <script>
        let currentArea = '';

        function searchSpecificArea(areaName) {
            document.getElementById('areaInput').value = areaName;
            searchArea();
        }

        async function searchArea() {
            const area = document.getElementById('areaInput').value.trim();

            if (!area) {
                showAlert('Please enter an area name', 'error');
                return;
            }

            currentArea = area;

            // Show loading
            document.getElementById('loadingMessage').style.display = 'block';
            document.getElementById('resultsContainer').style.display = 'none';
            document.getElementById('searchBtn').disabled = true;
            document.getElementById('searchBtn').textContent = '🔄 Searching...';

            try {
                const response = await fetch('area_checker_backend.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ area: area })
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const result = await response.json();

                if (result.success) {
                    displayResults(result.data);
                    showAlert(`Found information for ${area}!`, 'success');
                } else {
                    throw new Error(result.error || 'Failed to get area information');
                }

            } catch (error) {
                console.error('Area search error:', error);
                document.getElementById('resultsContainer').innerHTML = `
                    <div class="error-message">
                        <h3>Unable to get area information</h3>
                        <p>${error.message}</p>
                        <p>Please try a different area name or check your spelling.</p>
                    </div>
                `;
                document.getElementById('resultsContainer').style.display = 'block';
                showAlert('Search failed: ' + error.message, 'error');
            }

            // Hide loading and restore button
            document.getElementById('loadingMessage').style.display = 'none';
            document.getElementById('searchBtn').disabled = false;
            document.getElementById('searchBtn').textContent = '🔍 Search Area';
        }

        function displayResults(data) {
            const container = document.getElementById('resultsContainer');

            let html = `
                <div class="area-header">
                    <div class="area-name">${currentArea}</div>
                    <div class="area-subtitle">Local Area Information & Amenities</div>
                </div>

                <div class="categories-grid">
            `;

            // Education
            html += createCategoryCard(
                'education',
                '🎓',
                'Education',
                data.education || [],
                'No educational institutions found'
            );

            // Shopping & Groceries
            html += createCategoryCard(
                'shopping',
                '🛒',
                'Shopping & Groceries',
                data.shopping || [],
                'No shops or supermarkets found'
            );

            // Transport
            html += createCategoryCard(
                'transport',
                '🚌',
                'Transport',
                data.transport || [],
                'No transport information found'
            );

            // Healthcare
            html += createCategoryCard(
                'healthcare',
                '🏥',
                'Healthcare',
                data.healthcare || [],
                'No healthcare facilities found'
            );

            // Recreation & Amenities
            html += createCategoryCard(
                'recreation',
                '⚽',
                'Recreation & Amenities',
                data.recreation || [],
                'No recreational facilities found'
            );

            // Safety & Crime Stats
            html += createCategoryCard(
                'safety',
                '🛡️',
                'Safety & Crime Information',
                data.safety || [],
                'No safety information found'
            );

            html += '</div>';

            container.innerHTML = html;
            container.style.display = 'block';
        }

        function createCategoryCard(categoryClass, icon, title, items, noResultsText) {
            let itemsHTML = '';

            if (items && items.length > 0) {
                itemsHTML = items.map(item => `
                    <li class="item">
                        <div>
                            <div class="item-name">${item.name}</div>
                            ${item.address ? `<div class="item-details">${item.address}</div>` : ''}
                            ${item.description ? `<div class="item-details">${item.description}</div>` : ''}
                        </div>
                        <div style="display: flex; align-items: center;">
                            ${item.rating ? `<span class="item-rating">${item.rating}</span>` : ''}
                            ${item.distance ? `<span class="item-distance">${item.distance}</span>` : ''}
                        </div>
                    </li>
                `).join('');
            } else {
                itemsHTML = `<div class="no-results">${noResultsText}</div>`;
            }

            return `
                <div class="category-card category-${categoryClass}">
                    <div class="category-header">
                        <span class="category-icon">${icon}</span>
                        <div class="category-title">${title}</div>
                    </div>
                    <ul class="items-list">
                        ${itemsHTML}
                    </ul>
                </div>
            `;
        }

        // Allow Enter key to search
        document.getElementById('areaInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchArea();
            }
        });
    </script>

<?php include 'footer.php'; ?>