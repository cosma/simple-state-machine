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

use Cosma\SimpleStateMachine\StateMachine;
use Cosma\SimpleStateMachine\Graphic;
use Cosma\SimpleStateMachine\Example\Price;
use Cosma\SimpleStateMachine\AbstractState;
use Cosma\SimpleStateMachine\Example\States\Subst2;

class StateMachineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @see Cosma\SimpleStateMachine\StateMachine::run
     *
     * @expectedException \Exception
     */
    public function testRun_StateNotSetException()
    {
        $stateMachine = new StateMachine();
        $stateMachine->run();
    }

    /**
     * @see Cosma\SimpleStateMachine\StateMachine::draw
     *
     * @expectedException \Exception
     */
    public function testDraw_StateNotSetException()
    {
        $stateMachine = new StateMachine();
        $graphic = new Graphic();
        $stateMachine->draw($graphic);
    }

    /**
     * @see Cosma\SimpleStateMachine\StateMachine
     */
    public function testStateMachine_TransitionToSubst40State()
    {
        $price = new Price(25.50);
        $startState = new Subst2($price);

        $stateMachine = new StateMachine();
        $stateMachine->setState($startState);
        $stateMachine->run();

        $this->assertEquals('Subst 40', $stateMachine->getState()->getLabel(), 'Transition to Subst 40 State did not take place');

        $this->assertEquals(8.50, $stateMachine->getState()->getData()->getValue());

        $statesNameHistory = array();

        /** @var AbstractState $state */
        foreach($stateMachine->getStatesHistory() as $state)
        {
            $statesNameHistory[] = $state->getLabel();
        }

        $this->assertEquals(
            array(
                'Subst 2',
                'Add 5',
                'Add 20',
                'Subst 40'
            ),
            $statesNameHistory,
            'Transitions did not follow the right way'
        );
    }

    /**
     * @see Cosma\SimpleStateMachine\StateMachine
     */
    public function testStateMachine_TransitionToSubst40StateDirectly()
    {
        $price = new Price(55.50);
        $startState = new Subst2($price);

        $stateMachine = new StateMachine();
        $stateMachine->setState($startState);
        $stateMachine->run();

        $this->assertEquals('Subst 40', $stateMachine->getState()->getLabel(), 'Transition to Subst 40 State did not take place');

        $statesNameHistory = array();

        /** @var AbstractState $state */
        foreach($stateMachine->getStatesHistory() as $state)
        {
            $statesNameHistory[] = $state->getLabel();
        }

        $this->assertEquals(
            array(
                'Subst 2',
                'Subst 40'
            ),
            $statesNameHistory,
            'Transitions did not follow the right way'
        );
    }

    /**
     * @see Cosma\SimpleStateMachine\StateMachine
     */
    public function testStateMachine_TransitionWithLoop()
    {
        $price = new Price(10);
        $startState = new Subst2($price);

        $stateMachine = new StateMachine();
        $stateMachine->setState($startState);
        $stateMachine->run();

        $this->assertEquals('Subst 40', $stateMachine->getState()->getLabel(), 'Transition to Subst 40 State did not take place');

        $statesNameHistory = array();

        /** @var AbstractState $state */
        foreach($stateMachine->getStatesHistory() as $state)
        {
            $statesNameHistory[] = $state->getLabel();
        }

        $this->assertEquals(
            array(
                'Subst 2',
                'Add 20',
                'Add 20',
                'Subst 40'
            ),
            $statesNameHistory,
            'Transitions did not follow the right way'
        );
    }

    /**
     * @see Cosma\SimpleStateMachine\Graphic
     */
    public function testGraph_SVGGraphic()
    {

        $graphic = new Graphic('svg');

        if(!$graphic->isDOTInstalled())
        {
            $this->markTestSkipped("dot command from graphviz is not installed. Please try 'sudo apt-get install graphviz'");
        }

        $stateMachine = new StateMachine('Simple State Machine Example');

        $startState = new Subst2();
        $stateMachine->setState($startState);

        $SVGExport = $stateMachine->draw($graphic);

        $this->assertContains('<svg', $SVGExport, 'SVG export is wrong');
        $this->assertContains('<title>Simple State Machine Example</title>', $SVGExport, 'SVG export is wrong');
        $this->assertContains('<title>Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst2</title>', $SVGExport, 'SVG export is wrong');
        $this->assertContains('<title>Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst40</title>', $SVGExport, 'SVG export is wrong');
        $this->assertContains('<title>Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst2&#45;&gt;Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst40</title>', $SVGExport, 'SVG export is wrong');
        $this->assertContains('<title>Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add5</title>', $SVGExport, 'SVG export is wrong');
        $this->assertContains('<title>Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst2&#45;&gt;Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add5</title>', $SVGExport, 'SVG export is wrong');
        $this->assertContains('</svg>', $SVGExport, 'SVG export is wrong');
    }

    /**
     * @see Cosma\SimpleStateMachine\Graphic
     */
    public function testGraph_DOTGraphic()
    {
        $graphic = new Graphic('dot');

        if(!$graphic->isDOTInstalled())
        {
            $this->markTestSkipped("dot command from graphviz is not installed. Please try 'sudo apt-get install graphviz'");
        }

        $stateMachine = new StateMachine('Simple State Machine Example');

        $startState = new Subst2();
        $stateMachine->setState($startState);

        $DOTExport = $stateMachine->draw($graphic);

        $expectedDOT = "digraph G {
  \"Simple State Machine Example\" [color=\"#8E949B\" shape=\"box\" peripheries=2 fillcolor=\"pink2\" style=\"filled\" penwidth=1 fontcolor=\"#ffffff\" height=0 label=\"Simple State Machine Example\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst2\" [fillcolor=\"#A8CE9F\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Subst 2\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst40\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Subst 40\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add5\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Add 5\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add20\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Add 20\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add15\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Add 15\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst17\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Subst 17\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst2\" -> \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst40\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\" &gt; 50\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add20\" -> \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add20\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\"Less \l Than 30\" dir=\"none\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add20\" -> \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst40\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 label=\"\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add5\" -> \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add20\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\"Less \l Than 30\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add5\" -> \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add15\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\"Less \l Than 50\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add5\" -> \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst17\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 label=\"\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst2\" -> \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add5\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\"Greater \l Than 20\"]
  \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Subst2\" -> \"Cosma\\\SimpleStateMachine\\\Example\\\States\\\Add20\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 label=\"\"]
}
";

        $this->assertEquals($expectedDOT, $DOTExport, 'DOT export is wrong');
    }

    /**
     * @see Cosma\SimpleStateMachine\StateMachine::draw
     */
    public function testGraph_SaveSvgToDisk()
    {
        $format = "bmp";

        @unlink('tests/coverage/_stateMachine.'.$format);
        $file = @fopen('tests/coverage/_stateMachine.'.$format, 'w+');

        $graphic = new Graphic($format);

        if(!$graphic->isDOTInstalled())
        {
            $this->markTestSkipped("dot command from graphviz is not installed. Please try 'sudo apt-get install graphviz'");
        }

        $stateMachine = new StateMachine('Simple State Machine Example');

        $startState = new Subst2();
        $stateMachine->setState($startState);

        $graphicStateMachine = $stateMachine->draw($graphic);

        @fwrite($file, $graphicStateMachine);

        @fclose($file);
    }
}