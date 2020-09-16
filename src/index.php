<?php

$loggedIn = $_SESSION["loggedIn"];

if (isset($loggedIn)) {
    if ($loggedIn) {
        // show home
    } else {
        // show login
    }
} else {
    // show login
}