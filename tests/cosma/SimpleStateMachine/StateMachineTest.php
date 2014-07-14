<?php
/**
 * This file is part of the "SimpleStateMachine" project
 *
 * (c) Cosmin Voicu<cosmin.voicu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 12/07/14
 * Time: 01:52
 */

namespace cosma\SimpleStateMachine;

use cosma\SimpleStateMachine\States\Subst2;
use Fhaculty\Graph\Exporter\Image;
use Fhaculty\Graph\Graph;

class StateMachineTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @see cosma\SimpleStateMachine\StateMachine
     */
    public function testGraph_Graphic()
    {
        unlink('tests/coverage/_stateMachine.html');
        $file = @fopen('tests/coverage/_stateMachine.html', 'w+');

        $graphic = new Graphic('svg');

        $stateMachine = new StateMachine();

        $startState = new Subst2();
        $stateMachine->setState($startState);

        $graphicStateMachine = $stateMachine->draw($graphic);


        @fwrite($file, $graphicStateMachine);

        @fclose($file);
    }

}