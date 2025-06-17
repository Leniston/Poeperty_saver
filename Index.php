<?php include 'header.php'; ?>

    <!-- Page-specific mobile-friendly styles -->
    <style>
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 1rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
            min-height: 44px; /* Touch-friendly */
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
            min-height: 80px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .properties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .property-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
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
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .property-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .property-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .property-date {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .property-price {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1rem;
        }

        .property-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .status-interested { background: #d4edda; color: #155724; }
        .status-viewing { background: #fff3cd; color: #856404; }
        .status-offer { background: #cce5ff; color: #004085; }
        .status-rejected { background: #f8d7da; color: #721c24; }

        .property-notes {
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .property-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .property-link {
            flex: 1;
            text-decoration: none;
            background: #f8f9fa;
            color: #333;
            padding: 10px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            font-size: 0.9rem;
            min-height: 44px;
            justify-content: center;
        }

        .property-link:hover {
            background: #e9ecef;
            color: #667eea;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            color: white;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .no-properties {
            text-align: center;
            color: white;
            padding: 40px 20px;
        }

        .no-properties h3 {
            font-size: 1.3rem;
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
            padding: 10px;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 15px;
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
            padding: 5px;
        }

        .loading {
            text-align: center;
            color: white;
            padding: 20px;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .properties-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .property-card {
                padding: 15px;
            }

            .property-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .property-actions {
                flex-direction: column;
                gap: 8px;
            }

            .property-link {
                flex: none;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .stat-card {
                padding: 12px;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .modal-content {
                margin: 20px 10px;
                padding: 15px;
                max-height: calc(100vh - 40px);
            }

            .btn {
                padding: 12px 20px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 480px) {
            .property-card {
                padding: 12px;
            }

            .property-title {
                font-size: 1.1rem;
            }

            .stats {
                grid-template-columns: 1fr 1fr;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 10px;
            }
        }
    </style>

    <div class="content-section">
        <h2 style="margin-bottom: 20px; color: #333;">Add New Property</h2>
        <form id="propertyForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="propertyUrl">Property URL *</label>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <input type="url" id="propertyUrl" name="url" required placeholder="https://www.daft.ie/ or myhome.ie/..." style="flex: 1; min-width: 200px;">
                        <button type="button" class="btn" onclick="autoFillProperty()" style="padding: 8px 12px; font-size: 0.85rem; white-space: nowrap;">🔍 Auto-Fill</button>
                    </div>
                    <small style="color: #666; font-size: 0.8rem;">Supports: Daft.ie, MyHome.ie, Property Partners, Sherry FitzGerald, Remax & more</small>
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
            <h2 style="margin-bottom: 15px;">Edit Property</h2>
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
                                <img src="${imageUrl}" alt="Property image" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;"
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
                            <a href="property_detail.php?id=${property.id}" class="property-link" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; font-weight: 600;">
                                <span>🔍</span> View Details
                            </a>
                            <a href="${property.url}" target="_blank" class="property-link">
                                <span>🔗</span> View Listing
                            </a>
                            <button class="btn btn-secondary" onclick="openEditModal(${property.id})" style="padding: 8px 12px; font-size: 0.85rem; flex: none;">
                                ✏️ Edit
                            </button>
                            <button class="btn btn-danger" onclick="deleteProperty(${property.id})" style="padding: 8px 12px; font-size: 0.85rem; flex: none;">
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

            // Show loading state
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '⏳ Loading...';
            button.disabled = true;

            try {
                const response = await fetch('property_scraper.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ url: url })
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const result = await response.json();

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