<?php
/**
 *
 */
 require __DIR__ . "/autoload.php";
 require __DIR__ . "/config.php";

// Handels incoming variables.
$number  = $_POST["number"] ?? null;
$tries   = $_POST["tries"] ?? null;
$guess   = $_POST["guess"] ?? null;
$doInit  = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;


// Game logic
if ($doInit || $number === null) {
    $number = rand(1, 100);
    $tries = 5;
    //header("Location: index_get.php?tries=$tries&number=$number");
} elseif ($doGuess) {
    $tries -= 1;
    if ($guess === $number) {
        $res = "Correct!";
    } elseif ($guess > $number) {
        $res = "Too high!";
    } else {
        $res = "Too low!";
    }
}


// Page rendering
require __DIR__ . "/view/guess_my_number_post.php";
