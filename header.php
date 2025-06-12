<?php
// header.php - Shared header component
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Mobile App-like experience -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Property Tools">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏠</text></svg>">

    <title><?php
        switch($current_page) {
            case 'index': echo 'Property Saver'; break;
            case 'calculator': echo 'Property Calculator'; break;
            case 'mortgage': echo 'Mortgage Calculator'; break;
            case 'location_analyzer': echo 'Location Analyzer'; break;
            default: echo 'Property Tools';
        }
        ?></title>

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
            padding: 10px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1rem;
            opacity: 0.9;
            margin: 0 10px;
        }

        .navigation {
            text-align: center;
            margin-bottom: 20px;
        }

        .nav-link {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 20px;
            margin: 5px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: rgba(255,255,255,0.4);
            font-weight: 600;
        }

        /* Common styles for all pages */
        .content-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 44px; /* Touch-friendly minimum */
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-danger {
            background: #dc3545;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: none;
            font-size: 0.9rem;
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

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            body {
                padding: 5px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .header p {
                font-size: 0.9rem;
            }

            .nav-link {
                display: block;
                margin: 3px auto;
                max-width: 200px;
                text-align: center;
                padding: 12px 16px;
            }

            .navigation {
                margin-bottom: 15px;
            }

            .content-section {
                padding: 15px;
                border-radius: 12px;
                margin-bottom: 15px;
            }

            .btn {
                width: 100%;
                justify-content: center;
                padding: 14px 20px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.8rem;
            }

            .header p {
                font-size: 0.8rem;
            }

            .nav-link {
                font-size: 0.85rem;
                padding: 10px 14px;
            }

            .content-section {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>
            <?php
            switch($current_page) {
                case 'index': echo '🏠 Property Saver'; break;
                case 'calculator': echo '💰 Property Calculator'; break;
                case 'mortgage': echo '📊 Mortgage Calculator'; break;
                case 'location_analyzer': echo '🗺️ Location Analyzer'; break;
                default: echo '🏠 Property Tools';
            }
            ?>
        </h1>
        <p>
            <?php
            switch($current_page) {
                case 'index': echo 'Keep track of all your property searches in one place'; break;
                case 'calculator': echo 'Calculate total costs and remaining funds for different scenarios'; break;
                case 'mortgage': echo 'Calculate monthly payments and total costs for different mortgage scenarios'; break;
                case 'location_analyzer': echo 'Automatically analyze travel times to your key locations'; break;
                default: echo 'Your complete property search toolkit';
            }
            ?>
        </p>
    </div>

    <div class="navigation">
        <a href="index.php" class="nav-link <?php echo $current_page === 'index' ? 'active' : ''; ?>">
            🏠 Property Saver
        </a>
        <a href="location_analyzer.php" class="nav-link <?php echo $current_page === 'location_analyzer' ? 'active' : ''; ?>">
            🗺️ Location Analyzer
        </a>
        <a href="calculator.php" class="nav-link <?php echo $current_page === 'calculator' ? 'active' : ''; ?>">
            💰 Property Calculator
        </a>
        <a href="mortgage.php" class="nav-link <?php echo $current_page === 'mortgage' ? 'active' : ''; ?>">
            📊 Mortgage Calculator
        </a>
    </div>

    <div id="alert" class="alert"></div>