<?php
/**
 *
 */
 require __DIR__ . "/autoload.php";
 require __DIR__ . "/config.php";

// Start session.
session_name();


// Session variables.
$number  = $_SESSION ['number'] ?? null;
$tries   = $_SESSION ['tries'] ?? null;

// Incoming variables from POST.
$guess   = $_POST["guess"] ?? null;
$doInit  = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;

// Game handler
if ($doInit || $number === null) {
    session_destroy();
    session_start();
    $current = new Guess();
    $_SESSION["number"] = $current->number();
    $_SESSION["tries"] = $current->tries();
} elseif ($doGuess) {
    $current = new Guess($number, $tries);
    $res = $current -> makeGuess($guess);
    $_SESSION["tries"] = $current -> tries();
}


// Page rendering
require __DIR__ . "/view/guess_my_number_post.php";
