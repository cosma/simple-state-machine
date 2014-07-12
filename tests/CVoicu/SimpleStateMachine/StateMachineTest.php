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

use CVoicu\SimpleStateMachine\States\Subst2;

class StateMachineTest extends \PHPUnit_Framework_TestCase
{
    public function testStateMachine_TransitionTo_Add5_State()
    {
        $stateMachine = new StateMachine();

        $price = new Price(25.50);
        $startState = new Subst2($price);

        $stateMachine->run($startState);

        $this->assertEquals('CVoicu\SimpleStateMachine\States\Add5', $stateMachine->getState()->getName(), 'Transition to Add5 State did not take place');

        $this->assertEquals(28.50, $price->getValue());

        $statesNameHistory = array();

        /** @var AbstractState $state */
        foreach($stateMachine->getStatesHistory() as $state)
        {
            $statesNameHistory[] = $state->getName();
        }
        $this->assertEquals(
            array(
                'CVoicu\SimpleStateMachine\States\Subst2',
                'CVoicu\SimpleStateMachine\States\Add5'
            ),
            $statesNameHistory,
            'Transitions did not follow the right way'
        );
    }

    public function testStateMachine_TransitionToAdd20_State()
    {
        $stateMachine = new StateMachine();

        $price = new Price(5.50);
        $startState = new Subst2($price);

        $stateMachine->run($startState);

        $this->assertEquals('CVoicu\SimpleStateMachine\States\Add20', $stateMachine->getState()->getName(), 'Transition to Add5EuroToPrice State did not take place');
    }

    public function testStateMachine_TransitionTo_Subst40_State()
    {
        $stateMachine = new StateMachine();

        $price = new Price(55.50);
        $startState = new Subst2($price);

        $stateMachine->run($startState);

        $this->assertEquals('CVoicu\SimpleStateMachine\States\Subst40', $stateMachine->getState()->getName(), 'Transition to Subst40 State did not take place');
    }

}