<?php
require_once '../includes/session.php';

// Destroy the session
destroyUserSession();

// Redirect to home page
header("Location: ../index.php");
exit();
?>
