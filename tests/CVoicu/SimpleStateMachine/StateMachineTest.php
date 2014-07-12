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

namespace CVoicu\SimpleStateMachine;

use CVoicu\SimpleStateMachine\States\Subst2EuroState;

class StateMachineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testStateMachine_StartStateNotSetException()
    {
        $stateMachine = new StateMachine();
        $somethig = '';
        $stateMachine->run($somethig);
    }


    public function testStateMachine_TransitionToAdd5EuroToPriceState()
    {
        $stateMachine = new StateMachine();

        $price = new Price(25.50);
        $startState = new Subst2EuroState($price);

        $stateMachine->run($startState);

        $this->assertEquals('CVoicu\SimpleStateMachine\States\Add5EuroState', $stateMachine->getState()->getName(), 'Transition to Add5EuroToPrice State did not take place');

        $this->assertEquals(28.50, $price->getValue());
    }

    public function testStateMachine_TransitionToAdd20EuroState()
    {
        $stateMachine = new StateMachine();

        $price = new Price(5.50);
        $startState = new Subst2EuroState($price);

        $stateMachine->run($startState);

        $this->assertEquals('CVoicu\SimpleStateMachine\States\Add20EuroState', $stateMachine->getState()->getName(), 'Transition to Add5EuroToPrice State did not take place');
    }

}