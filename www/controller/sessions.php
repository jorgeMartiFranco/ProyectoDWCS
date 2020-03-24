<?php
namespace MobilitySharp\controller\sessions;

/**
 * Starts or recovers the session.
 * 
 * If the session was already set, this method does nothing.
 */
function startSession() {
    if(!isset($_SESSION)){
        session_start();
    }
}

/**
 * Redirects user to root if it's not logged in.
 * 
 * Checks if the user was logged in by checking the session variables.
 * The user will be redirected to Document Root if the user variable is not set.
 */
function checkLogin() {
    if(!isset($_SESSION['user'])) {
        header('Location: /');
    }
}