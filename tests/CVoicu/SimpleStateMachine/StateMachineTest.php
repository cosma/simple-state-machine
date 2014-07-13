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
use Fhaculty\Graph\Exporter\Image;
use \Fhaculty\Graph\Graph;

class StateMachineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @see CVoicu\SimpleStateMachine\StateMachine
     *
     * @expectedException \Exception
     */
    public function testStateMachine_StateNotSetException()
    {
        $stateMachine = new StateMachine();
        $stateMachine->run();
    }

    /**
     * @see CVoicu\SimpleStateMachine\StateMachine
     */
    public function testStateMachine_TransitionTo_Add5_State()
    {
        $price = new Price(25.50);
        $startState = new Subst2($price);

        $stateMachine = new StateMachine();
        $stateMachine->setState($startState);
        $stateMachine->run();

        $this->assertEquals('Add 5', $stateMachine->getState()->getLabel(), 'Transition to Add5 State did not take place');

        $this->assertEquals(28.50, $price->getValue());

        $statesNameHistory = array();

        /** @var AbstractState $state */
        foreach($stateMachine->getStatesHistory() as $state)
        {
            $statesNameHistory[] = $state->getLabel();
        }
        $this->assertEquals(
            array(
                'Subst 2',
                'Add 5'
            ),
            $statesNameHistory,
            'Transitions did not follow the right way'
        );
    }

    /**
     * @see CVoicu\SimpleStateMachine\StateMachine
     */
    public function testStateMachine_TransitionToAdd20_State()
    {
        $price = new Price(5.50);
        $startState = new Subst2($price);

        $stateMachine = new StateMachine();
        $stateMachine->setState($startState);
        $stateMachine->run();

        $this->assertEquals('Add 20', $stateMachine->getState()->getLabel(), 'Transition to Add5EuroToPrice State did not take place');
    }

    /**
     * @see CVoicu\SimpleStateMachine\StateMachine
     */
    public function testStateMachine_TransitionTo_Subst40_State()
    {
        $price = new Price(55.50);
        $startState = new Subst2($price);

        $stateMachine = new StateMachine();
        $stateMachine->setState($startState);
        $stateMachine->run();

        $this->assertEquals('Subst 40', $stateMachine->getState()->getLabel(), 'Transition to Subst40 State did not take place');
    }

    /**
     * @see CVoicu\SimpleStateMachine\StateMachine
     */
    public function testGraph_Graphic()
    {
        $graphic = new Graphic('svg');

        $stateMachine = new StateMachine();

        $startState = new Subst2();
        $stateMachine->setState($startState);

        $graphicStateMachine = $stateMachine->draw($graphic);

        $file = @fopen('tests/coverage/_stateMachine.html', 'w+');
        @fwrite($file, $graphicStateMachine);
    }

    /**
     * @see CVoicu\SimpleStateMachine\StateMachine
     */
    public function testGraph_ClueGraph()
    {
        $graph = new Graph();

        // create some cities
        $Subst2 = $graph->createVertex('Subst2')->setLayout(array('fillcolor'=>"#1b9e77",'color'=>'black','style'=>'filled','penwidth'=>1));
        $Subst40 = $graph->createVertex('Subst40');
        $Add5 = $graph->createVertex('Add5');
        $Add20 = $graph->createVertex('Add20');

        $Add20 = $graph->createVertex('Add20', true);
        $Add20ee = $graph->createVertex('dasdas');

        // build some roads

        $Subst2->createEdgeTo($Subst40)->setLayout(array('headlabel' => 'GreaterThen50','color'=>"#377eb8",'fontsize'=>8,'fontcolor'=>'black', 'labeldistance' => 2, 'labelangle' => 40));
        $Subst2->createEdgeTo($Add5)->setLayout(array('headlabel' => 'GreaterThen20','color'=>"#377eb8",'fontsize'=>8,'fontcolor'=>'black', 'labeldistance' => 2, 'labelangle' => 40));
        $Subst2->createEdgeTo($Add20);

        // create loop
        $Add20->createEdgeTo($Add20);

        $exporter = new Image();
        $image = $exporter->getOutput($graph);
        $file = @fopen('tests/coverage/_graphresults.png', 'w+');
        @fwrite($file, $image);

        // http://www.graphviz.org/doc/info/output.html#d:svg
        $exporter->setFormat('svg');

        $image = $exporter->getOutput($graph);

        //print_r($image);

        $file = @fopen('tests/coverage/_graphresults.html', 'w+');
        @fwrite($file, $image);
    }
}