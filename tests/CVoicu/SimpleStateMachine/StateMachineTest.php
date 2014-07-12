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

use Alom\Graphviz\Digraph as AlomDigraph;
use CVoicu\SimpleStateMachine\States\Subst2;
use Fhaculty\Graph\Exporter\Image;
use \Fhaculty\Graph\Graph as FhacultyGraph;

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

    public function testGraph_ClueGraph()
    {
        $graph = new FhacultyGraph();

        // create some cities
        $Subst2 = $graph->createVertex('Subst2');;
        $Subst40 = $graph->createVertex('Subst40');
        $Add5 = $graph->createVertex('Add5');
        $Add20 = $graph->createVertex('Add20');

        // build some roads
        $Subst2->createEdgeTo($Subst40)->setLayout(array('label' => 'GreaterThen50'));
        $Subst2->createEdgeTo($Add5)->setLayout(array('label' => 'GreaterThen20'));
        $Subst2->createEdgeTo($Add20);

        // create loop
        $Add20->createEdgeTo($Add20);

        $exporter = new Image();
        $image = $exporter->getOutput($graph);
        $file = @fopen('tests/coverage/graphresults.png', 'w+');
        @fwrite($file, $image);

        // http://www.graphviz.org/doc/info/output.html#d:svg
        $exporter->setFormat('svg');

        $image = $exporter->getOutput($graph);

        //print_r($image);

        $file = @fopen('tests/coverage/graphresults.html', 'w+');
        @fwrite($file, $image);
    }







}