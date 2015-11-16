PHP Talent Test

Your company would like to develop an online dice game. The game rules are as below:

1. The game contains 4 players.
2. Each player will have 6 dice in their dice up.
3. Each round all players will roll their dice at the same time.
4. All dice with number 1 on top side will be passed to player on his right hand (the right most player will pass the dice to left most player)
5. All dice with number 6 on top side will be removed from their dice cup.
6. All players roll their dice again to start next round.
7. The player who first emptied their dice cup (could be more than 1 player) is winner(s).

You are required to write a PHP code to simulate this game and print out the result of each round until winner(s) is found.


Example of output:

Round 1

After dice rolled:
Player A: 3, 4, 5, 6, 1, 1
Player B: 5, 4, 5, 4, 3, 1
Player C: 6, 6, 6, 3, 2, 4
Player D: 5, 1, 3, 2, 4, 1

After dice moved/removed:
Player A: 3, 4, 5, 1 ,1
Player B: 5, 4, 5, 4, 3, 1, 1
Player C: 3, 2, 4, 1
Player D: 5, 3, 2, 4

Round 2:

After dice rolled:
Player A: 2, 3, 6, 2, 6
Player B: 6, 6, 6, 4, 1, 3
Player C: 3, 2, 1, 6
Player D: 6, 6, 1, 2

After dice moved/removed:
Player A: 2, 3, 2, 1
Player B: 4, 1, 3
Player C: 3, 2, 1
Player D: 2, 1
(Repeat until winner(s) is found)


Solution:

<?php

/**
 * @author  Amit Shah
 */
class Player
{

    private $cntMaxDice, $cntDice, $dicePrefix = 'D';

    function __construct($intDice = 6)  //Default value = 6
    {        
        $this->cntDice = $intDice;      //Initial number of Dice

        //Initial values for all dice
        for ($i = 1; $i <= $intDice; $i++)
        {
            $tVar = $this->dicePrefix . $i;
            $this->{$tVar} = NULL;
        }
    }

    //magic method to set properties which are not declared
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function setDiceValue(array $arrVal)
    {
        $this->_resetDice();    //empty all dice

        foreach ($arrVal as $val)   //refill with new values
        {
            $this->_addDice($val);
        }
    }


    private function _addDice(&$diceVal)
    {
        $this->cntDice++;   //increment of current dice count
        $tVar = $this->dicePrefix . $this->cntDice;
        $this->{$tVar} = $diceVal;
    }

    private function _removeDice($diceKey)
    {
        $tVar = $this->dicePrefix . $diceKey;
        unset($this->{$tVar});
        $this->cntDice--;
    }

    //Empty all dice
    private function _resetDice()
    {
        for ($i = 1; $i <= $this->cntDice; $i++)
        {
            $tVar = $this->dicePrefix . $i;
            unset($this->{$tVar});
        }
        $this->cntDice = 0;     //Set current Dice count to 0
    }

    //Return array of current Dice values
    public function getDiceValue()
    {
        $arrVal = array();

        for ($i = 1; $i <= $this->cntDice; $i++)
        {
            $tVar = $this->dicePrefix . $i;
            $arrVal[] = $this->{$tVar};
        }

        return $arrVal;
    }

    //Return current count of set dice
    public function getCurrentDiceCount()
    {
        return $this->cntDice;
    }

}

class DiceGame
{

    private $A, $B, $C, $D;     //Can also be declare dynamic like Dice in Player class
    private $arrPlayers = array('A', 'B', 'C', 'D');    //just to help iteration
    private $intDiceMinVal = 1;     //Minimum value of Dice
    private $intDiceMaxVal = 6;     //Maximum value of Dice

    function __construct($intDice = 6)
    {
        //Create Player object for all A,B,C,D
        $this->A = new Player($intDice);    
        $this->B = new Player($intDice);
        $this->C = new Player($intDice);
        $this->D = new Player($intDice);
    }

    public function rollDice()
    {
        $this->_rollDicePlayer($this->A);
        $this->_rollDicePlayer($this->B);
        $this->_rollDicePlayer($this->C);
        $this->_rollDicePlayer($this->D);
    }

    //Create randomly generated dice values for Player
    private function _rollDicePlayer(Player $Player)
    {
        $maxDice = $Player->getCurrentDiceCount();
        $arrDice = array();

        for ($i = 1; $i <= $maxDice; $i++)
        {
            $arrDice[] = $this->_getRandomInt($this->intDiceMinVal, $this->intDiceMaxVal);
        }

        $Player->setDiceValue($arrDice);
    }

    public function exchangeDice($intShift, $intRemove)
    {
        $this->_shiftDice($intShift);
        $this->_removeDice($intRemove);
    }

    //Exchange all the dice with 1 on top with neighbour
    private function _shiftDice($intShift)
    {
        foreach ($this->arrPlayers as $player)
        {
            $arrDice = $this->{$player}->getDiceValue();
            $arrKeys[$player] = array_keys($arrDice, $intShift);
            $this->_unsetDice($arrDice, $arrKeys[$player]);
            $this->{$player}->setDiceValue($arrDice);
        }

        $cntForward = null;
        foreach ($arrKeys as $player => $arrForward)
        {
            if (!is_null($cntForward) && $cntForward !== 0)
            {
                $arrDice = $this->{$player}->getDiceValue();
                $cntNewSize = count($arrDice) + $cntForward;
                $arrDice = array_pad($arrDice, $cntNewSize, $intShift);
                $this->{$player}->setDiceValue($arrDice);
            }
            $cntForward = count($arrForward);
        }
        foreach ($arrKeys as $player => $arrForward)
        {
            if (!is_null($cntForward) && $cntForward !== 0)
            {
                $arrDice = $this->{$player}->getDiceValue();
                $cntNewSize = count($arrDice) + $cntForward;
                $arrDice = array_pad($arrDice, $cntNewSize, $intShift);
                $this->{$player}->setDiceValue($arrDice);
            }
            break;
        }
    }

    private function _unsetDice(&$arrDice, &$arrKeys)
    {
        foreach ($arrKeys as $key)
        {
            unset($arrDice[$key]);
        }
    }



    //Remove all the dice with 6 on top from the Player
    private function _removeDice($intRemove)
    {
        foreach ($this->arrPlayers as $player)
        {
            $arrDice = $this->{$player}->getDiceValue();
            $arrKeys[$player] = array_keys($arrDice, $intRemove);
            $this->_unsetDice($arrDice, $arrKeys[$player]);
            $this->{$player}->setDiceValue($arrDice);
        }
    }

    private function _getRandomInt($min, $max)
    {
        return rand($min, $max);
    }

    public function printStatus()
    {
        echo 'Player A:' . implode(",", $this->A->getDiceValue()) . "<br />\r\n";
        echo 'Player B:' . implode(",", $this->B->getDiceValue()) . "<br />\r\n";
        echo 'Player C:' . implode(",", $this->C->getDiceValue()) . "<br />\r\n";
        echo 'Player D:' . implode(",", $this->D->getDiceValue()) . "<br />\r\n";
    }

    //Check if any player got emptied
    public function isAnyPlayerEmptied()
    {
        foreach ($this->arrPlayers as $player)
        {
            $cntDice = $this->{$player}->getCurrentDiceCount();
            if ($cntDice === 0)
            {
                return TRUE;
            }
        }
        return FALSE;
    }

}






//Run the code:

try
{
    $intDice = 6;
    $objDiceGame = new DiceGame($intDice);
    $cntRound = 0;

    do
    {
        $cntRound++;
        echo "Round " . $cntRound . "<br /><br />\r\n";
        $objDiceGame->rollDice();

        echo "After dice rolled:<br />\r\n";
        $objDiceGame->printStatus();

        $objDiceGame->exchangeDice($diceToShift = 1, $diceToRemove = 6);
        echo "<br />After dice moved/removed:<br />\r\n";
        $objDiceGame->printStatus();

        echo "<br /><br />";

        $isWinnerFound = $objDiceGame->isAnyPlayerEmptied();
    }
    while ($isWinnerFound === FALSE);

    echo "Winner Found<br /><br />\r\n";
}
catch (Exception $e)
{
    echo $e->getMessage();
    echo $e->getTraceAsString();
}
?>

Sample Result:

Round 1

 After dice rolled:
 Player A:6,4,3,4,5,5
 Player B:5,4,6,6,1,6
 Player C:4,2,3,2,3,5
 Player D:1,5,5,4,1,5

After dice moved/removed:
 Player A:4,3,4,5,5,1,1
 Player B:5,4
 Player C:4,2,3,2,3,5,1
 Player D:5,5,4,5


Round 2

 After dice rolled:
 Player A:3,6,6,5,2,4,5
 Player B:6,2
 Player C:6,5,3,4,5,6,1
 Player D:6,4,6,6

After dice moved/removed:
 Player A:3,5,2,4,5
 Player B:2
 Player C:5,3,4,5
 Player D:4,1


Round 3

 After dice rolled:
 Player A:4,2,3,3,2
 Player B:6
 Player C:2,6,1,3
 Player D:2,4

After dice moved/removed:
 Player A:4,2,3,3,2
 Player B:
 Player C:2,3
 Player D:2,4,1


Winner Found
