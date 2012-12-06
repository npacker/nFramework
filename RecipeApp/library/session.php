<?php

session_start();

function verifySession() {
	if (isLoggedIn()) revalidateUser();
	else logout();
}

function isLoggedIn() {
	$session = false;

	if (!array_key_exists('fingerprint', $_SESSION) OR
			!array_key_exists('latest_activity', $_SESSION) OR
			!array_key_exists('start_time', $_SESSION)) {
		break;
	} else if ($_SESSION['fingerprint'] != fingerprint()) {
		break;
	} else if ($_SESSION['latest_activity'] + 300 < time()) {
		break;
	} else if ($_SESSION['start_time'] + 3600 < time()) {
		break;
	} else {
		$session = true;
	}

	return $session;
}

function validateUser() {
	session_regenerate_id(true);
	$_SESSION['fingerprint'] = fingerprint();
	$_SESSION['latest_activity'] = time();
	$_SESSION['start_time'] = time();
}

function revalidateUser() {
	session_regenerate_id(TRUE);
	$_SESSION['latest_activity'] = time();
}

function logout() {
	session_regenerate_id(TRUE);
	session_unset();
	$_SESSION = array();
	session_destroy();
}

function fingerprint() {
	return md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_ACCEPT'] . $_SERVER['HTTP_ACCEPT_ENCODING'] . $_SERVER['HTTP_ACCEPT_LANGUAGE']);
}