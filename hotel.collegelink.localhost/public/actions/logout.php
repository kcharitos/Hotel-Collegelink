<?php

// Set the expiration date to one hour ago
setcookie('user_token', $token, time() - 3600, '/');
header('Location: /public/index.php');

?>