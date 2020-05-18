<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for game start.
    session_destroy();
    session_start();
    $current = new Daje\Guess\Guess();
    $_SESSION["number"] = $current->number();
    $_SESSION["tries"] = $current->tries();

    return $app->response->redirect("guess/play");
});



/**
 * Play the game. - Show game status.
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game!";

    $tries = $_SESSION ['tries'] ?? null;
    $res = $_SESSION ['res'] ?? null;
    $guess = $_SESSION ['guess'] ?? null;
    $secret = $_SESSION["number"] ?? null;
    $doCheat = $_SESSION ['doCheat'] ?? null;

    $_SESSION ['res'] = null;
    $_SESSION ['guess'] = null;
    $_SESSION ['doCheat'] = null;



    $data = [
        "secret" => $secret ?? null,
        "guess" => $guess ?? null,
        "tries" => $tries,
        "number" => $number ?? null,
        "res" => $res,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
    ];

    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Play the game - make a guess, restart and cheat.
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Play the game!";

    // Incoming variables from POST.
    $guess   = $_POST["guess"] ?? null;
    $doInit  = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;

    // Session variables.
    $number  = $_SESSION ['number'] ?? null;
    $tries   = $_SESSION ['tries'] ?? null;
    $secret = $_SESSION["number"] ?? null;

    if ($doGuess) {
        $current = new Daje\Guess\Guess($number, $tries);
        $res = $current -> makeGuess($guess);
        $_SESSION["tries"] = $current -> tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
    }

    if ($doInit) {
        return $app->response->redirect("guess/init");
    }

    if ($doCheat) {
        $_SESSION["doCheat"] = $doCheat;
    }

    return $app->response->redirect("guess/play");
});
