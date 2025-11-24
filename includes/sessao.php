<?php

// define('WP_HOME', 'https://localhost/page_token/home.php');
// define('WP_SITEINDEX', 'https://localhost/page_token/index.php');

if (session_status() !== PHP_SESSION_ACTIVE) {

	session_start();
}

if (!isset($_SESSION['usuario'])) {
	header('Location: login');
	exit();
}
