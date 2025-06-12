<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0
	<!-- Mobile App-like experience -->
	
	<meta name="apple-mobile-web-app-capable" content="yes">
	
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	
	<meta name="apple-mobile-web-app-title" content="Property Saver">
	
	<link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🀀􈀀</text></svg>">
	
	
    <title>Property Saver</title>
=======
<?php include 'header.php'; ?>

    <!-- Page-specific styles -->
>>>>>>> 64054d96cf1d0ca5b477f098d2f7f5045f2450b1
    <style>
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .properties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 25px;
        }

        .property-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .property-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .property-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }

        .property-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .property-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .property-date {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .property-price {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .property-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .status-interested { background: #d4edda; color: #155724; }
        .status-viewing { background: #fff3cd; color: #856404; }
        .status-offer { background: #cce5ff; color: #004085; }
        .status-rejected { background: #f8d7da; color: #721c24; }

        .property-notes {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .property-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .property-link {
            flex: 1;
            text-decoration: none;
            background: #f8f9fa;
            color: #333;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .property-link:hover {
            background: #e9ecef;
            color: #667eea;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            color: white;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            opacity: 0.9;
            font-size: 1rem;
        }

        .no-properties {
            text-align: center;
            color: white;
            padding: 60px 20px;
        }

        .no-properties h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 20px;
            max-width: 500px;
            width: 90%;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .loading {
            text-align: center;
            color: white;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
<<<<<<< HEAD
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🏠 Property Saver</h1>
        <p>Keep track of all  property searches in one place</p>
		<p>Cause Daft's save function is too simple </P>
    </div>
=======
>>>>>>> 64054d96cf1d0ca5b477f098d2f7f5045f2450b1

    <div class="content-section">
        <h2 style="margin-bottom: 25px; color: #333;">Add New Property</h2>
        <form id="propertyForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="propertyUrl">Property URL *</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="url" id="propertyUrl" name="url" required placeholder="https://www.daft.ie/ or myhome.ie/ or any property site..." style="flex: 1;">
                        <button type="button" class="btn" onclick="autoFillProperty()" style="padding: 8px 16px; font-size: 0.9rem;">🔍 Auto-Fill</button>
                    </div>
                    <small style="color: #666; font-size: 0.9rem;">Supports: Daft.ie, MyHome.ie, Property Partners, Sherry FitzGerald, Remax & more</small>
                </div>
                <div class="form-group">
                    <label for="propertyPrice">Price</label>
                    <input type="text" id="propertyPrice" name="price" placeholder="€495,000">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="propertyTitle">Property Title</label>
                    <input type="text" id="propertyTitle" name="title" placeholder="3 bed house in Dublin">
                </div>
                <div class="form-group">
                    <label for="propertyStatus">Status</label>
                    <select id="propertyStatus" name="status">
                        <option value="interested">Interested</option>
                        <option value="viewing">Viewing Scheduled</option>
                        <option value="offer">Offer Made</option>
                        <option value="rejected">Rejected/Passed</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="propertyNotes">Notes</label>
                <textarea id="propertyNotes" name="notes" placeholder="Add any notes about this property..."></textarea>
            </div>

            <button type="submit" class="btn">
                <span>📋</span> Save Property
            </button>
        </form>
    </div>

    <div class="stats" id="stats">
        <div class="stat-card">
            <div class="stat-number" id="totalProperties">0</div>
            <div class="stat-label">Total Properties</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="interestedCount">0</div>
            <div class="stat-label">Interested</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="viewingCount">0</div>
            <div class="stat-label">Viewing</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="offerCount">0</div>
            <div class="stat-label">Offers Made</div>
        </div>
    </div>

    <div id="loadingMessage" class="loading">Loading properties...</div>

    <div class="properties-grid" id="propertiesGrid" style="display: none;">
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Property</h2>
            <form id="editForm">
                <input type="hidden" id="editId">
                <div class="form-group">
                    <label for="editUrl">Property URL</label>
                    <input type="url" id="editUrl" name="url" required>
                </div>
                <div class="form-group">
                    <label for="editTitle">Title</label>
                    <input type="text" id="editTitle" name="title">
                </div>
                <div class="form-group">
                    <label for="editPrice">Price</label>
                    <input type="text" id="editPrice" name="price">
                </div>
                <div class="form-group">
                    <label for="editStatus">Status</label>
                    <select id="editStatus" name="status">
                        <option value="interested">Interested</option>
                        <option value="viewing">Viewing Scheduled</option>
                        <option value="offer">Offer Made</option>
                        <option value="rejected">Rejected/Passed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editNotes">Notes</label>
                    <textarea id="editNotes" name="notes"></textarea>
                </div>
                <button type="submit" class="btn">Update Property</button>
            </form>
        </div>
    </div>

    <script>
        let properties = [];

        async function apiCall(endpoint, method = 'GET', data = null) {
            try {
                const options = {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                    }
                };

                if (data) {
                    options.body = JSON.stringify(data);
                }

                const response = await fetch(`backend.php?endpoint=${endpoint}`, options);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Unknown error');
                }

                return result;
            } catch (error) {
                console.error('API Error:', error);
                showAlert('Error: ' + error.message, 'error');
                throw error;
            }
        }

        async function loadProperties() {
            try {
                const result = await apiCall('properties');
                properties = result.data || [];
                renderProperties();
                updateStats();
                document.getElementById('loadingMessage').style.display = 'none';
                document.getElementById('propertiesGrid').style.display = 'grid';
            } catch (error) {
                document.getElementById('loadingMessage').textContent = 'Error loading properties. Check if database is set up.';
            }
        }

        async function addProperty(propertyData) {
            try {
                await apiCall('properties', 'POST', propertyData);
                await loadProperties();
                showAlert('Property saved successfully!');
            } catch (error) {
                // Handle error
            }
        }

        async function editProperty(id, propertyData) {
            try {
                await apiCall('properties', 'PUT', { ...propertyData, id: id });
                await loadProperties();
                showAlert('Property updated successfully!');
            } catch (error) {
                // Handle error
            }
        }

        async function deleteProperty(id) {
            if (confirm('Are you sure you want to delete this property?')) {
                try {
                    await apiCall('properties', 'DELETE', { id: id });
                    await loadProperties();
                    showAlert('Property deleted successfully!');
                } catch (error) {
                    // Handle error
                }
            }
        }

        function updateStats() {
            const stats = {
                total: properties.length,
                interested: properties.filter(p => p.status === 'interested').length,
                viewing: properties.filter(p => p.status === 'viewing').length,
                offer: properties.filter(p => p.status === 'offer').length
            };

            document.getElementById('totalProperties').textContent = stats.total;
            document.getElementById('interestedCount').textContent = stats.interested;
            document.getElementById('viewingCount').textContent = stats.viewing;
            document.getElementById('offerCount').textContent = stats.offer;
        }

        function extractImageFromNotes(notes) {
            if (!notes) return null;

            // Look for image URL in notes
            const imageMatch = notes.match(/Image:\s*(https?:\/\/[^\s|]+)/);
            return imageMatch ? imageMatch[1] : null;
        }

        function cleanNotesForDisplay(notes) {
            if (!notes) return '';

            // Remove the image URL from notes for display
            return notes.replace(/\s*\|\s*Image:\s*https?:\/\/[^\s|]+/g, '').trim();
        }

        function renderProperties() {
            const grid = document.getElementById('propertiesGrid');

            if (properties.length === 0) {
                grid.innerHTML = `
                <div class="no-properties">
                    <h3>No properties saved yet</h3>
                    <p>Add your first property using the form above!</p>
                </div>
            `;
                return;
            }

            grid.innerHTML = properties.map(property => {
                const imageUrl = extractImageFromNotes(property.notes);
                return `
                <div class="property-card">
                    ${imageUrl ? `
                        <div class="property-image">
                            <img src="${imageUrl}" alt="Property image" style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px; margin-bottom: 15px;"
                                 onerror="this.style.display='none'">
                        </div>
                    ` : ''}

                    <div class="property-header">
                        <div>
                            <div class="property-title">${property.title || 'Property'}</div>
                            <div class="property-date">${new Date(property.date_added).toLocaleDateString()}</div>
                        </div>
                        ${property.price ? `<div class="property-price">${property.price}</div>` : ''}
                    </div>

                    <div class="property-status status-${property.status}">
                        ${property.status.charAt(0).toUpperCase() + property.status.slice(1)}
                    </div>

                    ${property.notes ? `<div class="property-notes">${cleanNotesForDisplay(property.notes)}</div>` : ''}

                    <div class="property-actions">
                        <a href="${property.url}" target="_blank" class="property-link">
                            <span>🔗</span> View Property
                        </a>
                        <button class="btn btn-secondary" onclick="openEditModal(${property.id})" style="padding: 8px 15px; font-size: 0.9rem;">
                            ✏️ Edit
                        </button>
                        <button class="btn btn-danger" onclick="deleteProperty(${property.id})" style="padding: 8px 15px; font-size: 0.9rem;">
                            🗑️ Delete
                        </button>
                    </div>
                </div>
            `;
            }).join('');
        }

        function openEditModal(id) {
            const property = properties.find(p => p.id == id);
            if (!property) return;

            document.getElementById('editId').value = property.id;
            document.getElementById('editUrl').value = property.url;
            document.getElementById('editTitle').value = property.title || '';
            document.getElementById('editPrice').value = property.price || '';
            document.getElementById('editStatus').value = property.status;
            document.getElementById('editNotes').value = property.notes || '';

            document.getElementById('editModal').style.display = 'block';
        }

        // Auto-fill function
        async function autoFillProperty() {
            const url = document.getElementById('propertyUrl').value;

            if (!url) {
                showAlert('Please enter a property URL first', 'error');
                return;
            }

            // Check if it's a supported property site
            const supportedSites = ['daft.ie', 'myhome.ie', 'propertypartners.ie', 'sherry.ie', 'remax.ie'];
            const isSupported = supportedSites.some(site => url.includes(site));

            if (!isSupported) {
                showAlert('This site may not be fully supported, but we\'ll try to extract basic information');
            }

            // Show loading state
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '⏳ Loading...';
            button.disabled = true;

            try {
                console.log('Attempting to fetch property data from:', url);

                const response = await fetch('property_scraper.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ url: url })
                });

                console.log('Response status:', response.status);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const result = await response.json();
                console.log('Scraper result:', result);

                if (result.success) {
                    // Fill form with scraped data
                    if (result.data.title) {
                        document.getElementById('propertyTitle').value = result.data.title;
                    }
                    if (result.data.price) {
                        document.getElementById('propertyPrice').value = result.data.price;
                    }

                    // Build notes from scraped data (including image)
                    let notes = [];
                    if (result.data.property_type) notes.push(`Type: ${result.data.property_type}`);
                    if (result.data.bedrooms) notes.push(result.data.bedrooms);
                    if (result.data.bathrooms) notes.push(result.data.bathrooms);
                    if (result.data.address) notes.push(`Address: ${result.data.address}`);
                    if (result.data.ber_rating) notes.push(`BER: ${result.data.ber_rating}`);
                    if (result.data.image_url) notes.push(`Image: ${result.data.image_url}`);

                    if (notes.length > 0) {
                        document.getElementById('propertyNotes').value = notes.join(' | ');
                    }

                    showAlert(`Property information auto-filled from ${result.source}!`);
                } else {
                    showAlert('Could not extract property info: ' + result.error, 'error');
                }

            } catch (error) {
                console.error('Scraping error:', error);
                showAlert('Error connecting to scraper service: ' + error.message, 'error');
            }

            // Restore button
            button.innerHTML = originalText;
            button.disabled = false;
        }

        // Event listeners
        document.getElementById('propertyForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const propertyData = Object.fromEntries(formData);

            await addProperty(propertyData);
            this.reset();
        });

        document.getElementById('editForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const propertyData = Object.fromEntries(formData);
            const id = document.getElementById('editId').value;

            await editProperty(id, propertyData);
            document.getElementById('editModal').style.display = 'none';
        });

        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('editModal').style.display = 'none';
        });

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('editModal');
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Initialize
        loadProperties();
    </script>

<?php include 'footer.php'; ?>