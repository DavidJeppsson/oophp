<?php
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
     * @return int as the secret number.
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
        if ($this->tries < 1) {
             echo 'To many guesses! Press the Restart-button to play again.';
        } else {
            if ($guess < 1 || $guess > 100) {
                throw new GuessException("You can type only number between 1-100");
            }
            $this->tries--;
            if ($guess == $this->number) {
                $res = "Your guess {$guess} is correct! Press the Restart-button to play again.";
                session_destroy();
            } elseif ($guess > $this->number) {
                $res = "Your guess {$guess} is too high try again!";
            } else {
                $res = "Your guess {$guess} is too low try again!";
            };
            return $res;
        }
    }
}
