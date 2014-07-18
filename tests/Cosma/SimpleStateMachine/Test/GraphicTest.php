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

class GraphicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @see Cosma\SimpleStateMachine\AbstractGraphic::addLegend
     *
     * @expectedException \InvalidArgumentException
     */
    public function testAddLegend_EmptyLegendException()
    {
        $graphic = new Graphic();
        $graphic->addLegend('', array());
    }

    /**
     * @see Cosma\SimpleStateMachine\AbstractGraphic::addState
     *
     * @expectedException \InvalidArgumentException
     */
    public function testAddState_EmptyIdException()
    {
        $graphic = new Graphic();
        $graphic->addState('', '', array());
    }

    /**
     * @see Cosma\SimpleStateMachine\AbstractGraphic::addState
     *
     * @expectedException \InvalidArgumentException
     */
    public function testAddState_EmptyLabelException()
    {
        $graphic = new Graphic();
        $graphic->addState('Cosma\SimpleStateMachine\Example\States\EmptyLabelState', '', array());
    }

    /**
     * @see Cosma\SimpleStateMachine\AbstractGraphic::addTransition
     *
     * @expectedException \InvalidArgumentException
     */
    public function testAddTransition_EmptyFromStateException()
    {
        $graphic = new Graphic();
        $graphic->addTransition('', '', '', array());
    }

    /**
     * @see Cosma\SimpleStateMachine\AbstractGraphic::addTransition
     *
     * @expectedException \InvalidArgumentException
     */
    public function testAddTransition_EmptyTargetStateException()
    {
        $graphic = new Graphic();
        $graphic->addTransition('Cosma\SimpleStateMachine\Example\States\EmptyLabelState', '', '', array());
    }
}