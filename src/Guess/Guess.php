<?php

namespace Daje\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */
    private $number = null;
    private $tries = 6;



    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */

    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->tries = $tries;
        if ($number === -1) {
            $number = rand(1, 100);
            // random();
        }
        $this->number = $number;
    }




    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */

    public function random() : void
    {
        $this->number = rand(1, 100);
    }




    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */

    public function tries() : int
    {
        return $this->tries;
    }



    /**
     * Get the secret number.
     *
     */

    public function number()
    {
        return $this->number;
    }




    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guess is not between 1 and 100.
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess($guess)
    {
        $this -> tries --;

        $currentGuess = intval($guess);

        if ($currentGuess > 100 or $currentGuess < 1) {
            throw new GuessException("Only numbers between 1-100 are valid");
        } elseif ($currentGuess > $this -> number) {
            if ($this -> tries <= 0) {
                return "To many guesses! Press the Restart-button to play again.";
            } else {
                return "Your guess {$guess} is too high try again!";
            }
        } elseif ($currentGuess < $this -> number) {
            if ($this -> tries <= 0) {
                return "To many guesses! Press the Restart-button to play again.";
            } else {
                return "Your guess {$guess} is too low try again!";
            }
        } elseif ($currentGuess == $this -> number) {
            // if ( $this -> tries > 0) {
            //     session_destroy();
            // }
            return "Your guess {$guess} is correct! Press the Restart-button to play again.";
            session_destroy();
        }
    }
}
