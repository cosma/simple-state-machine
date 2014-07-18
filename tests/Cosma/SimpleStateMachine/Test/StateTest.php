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

namespace Cosma\SimpleStateMachine\Test;

use Cosma\SimpleStateMachine\Graphic;
use Cosma\SimpleStateMachine\Example\States\EmptyLabelState;

class StateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @see Cosma\SimpleStateMachine\AbstractState::draw
     *
     * @expectedException \Exception
     */
    public function testDraw_EmptyLabelException()
    {
        $state = new EmptyLabelState();
        $graphic = new Graphic();
        $state->draw($graphic);
    }

    /**
     * @see Cosma\SimpleStateMachine\AbstractState::addTransition
     *
     * @expectedException \InvalidArgumentException
     */
    public function testAddTransition_CannotLoadStateClassException()
    {
        $state = new EmptyLabelState();

        $state->addTransition('InexistentStateClass');
    }

    /**
     * @see Cosma\SimpleStateMachine\AbstractState::addTransition
     *
     * @expectedException \InvalidArgumentException
     */
    public function testAddTransition_CannotLoadConditionClassException()
    {
        $state = new EmptyLabelState();

        $state->addTransition('Cosma\SimpleStateMachine\Example\States\EmptyLabelState', 'InexistentStateClass');
    }
}