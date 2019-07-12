<?php
session_start();
function message() {
    if (isset($_SESSION['message'])) {
        $output = $_SESSION['message'];
        $_SESSION['message'] = null;
        return $output;
    }
}