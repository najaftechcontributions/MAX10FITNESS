<?php
/**
 * Logout View
 * Destroys the session and redirects to home
 */

destroyUserSession();
header("Location: /");
exit();
?>
