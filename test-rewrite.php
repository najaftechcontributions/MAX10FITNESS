<?php
/**
 * Test if mod_rewrite is working
 * Access this file at: /test-rewrite-check
 * If you see "mod_rewrite is WORKING!", then .htaccess is functioning
 * If you get a 404, mod_rewrite needs to be enabled
 */

if (isset($_GET['route']) && $_GET['route'] === 'test-rewrite-check') {
    echo '<h1 style="color: green;">✓ mod_rewrite is WORKING!</h1>';
    echo '<p>Your .htaccess file is being processed correctly.</p>';
    echo '<p><strong>Route received:</strong> ' . htmlspecialchars($_GET['route']) . '</p>';
} else {
    echo '<h1 style="color: red;">✗ mod_rewrite may not be working</h1>';
    echo '<p><strong>Expected route:</strong> test-rewrite-check</p>';
    echo '<p><strong>Received route:</strong> ' . (isset($_GET['route']) ? htmlspecialchars($_GET['route']) : 'none') . '</p>';
}
?>
