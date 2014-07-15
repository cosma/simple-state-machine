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

namespace Cosma\SimpleStateMachine;

use Cosma\SimpleStateMachine\States\Subst2;
use Fhaculty\Graph\Exporter\Image;
use Fhaculty\Graph\Graph;

class StateMachineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @see Cosma\SimpleStateMachine\StateMachine
     *
     * @expectedException \Exception
     */
    public function testStateMachine_StateNotSetException()
    {
        $stateMachine = new StateMachine();
        $stateMachine->run();
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

        $this->assertEquals(8.50, $price->getValue());

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

        $stateMachine = new StateMachine();

        $startState = new Subst2();
        $stateMachine->setState($startState);

        $SVGExport = $stateMachine->draw($graphic);

        $expectedSVG = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>
<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\"
 \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">
<!-- Generated by graphviz version 2.36.0 (20140111.2315)
 -->
<!-- Title: G Pages: 1 -->
<svg width=\"509pt\" height=\"302pt\"
 viewBox=\"0.00 0.00 509.00 302.00\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">
<g id=\"graph0\" class=\"graph\" transform=\"scale(1 1) rotate(0) translate(4 298)\">
<title>G</title>
<polygon fill=\"white\" stroke=\"none\" points=\"-4,4 -4,-298 505,-298 505,4 -4,4\"/>
<!-- Simple State Machine -->
<g id=\"node1\" class=\"node\"><title>Simple State Machine</title>
<polygon fill=\"#eea9b8\" stroke=\"#8e949b\" points=\"144,-287.5 4,-287.5 4,-264.5 144,-264.5 144,-287.5\"/>
<polygon fill=\"none\" stroke=\"#8e949b\" points=\"148,-291.5 0,-291.5 0,-260.5 148,-260.5 148,-291.5\"/>
<text text-anchor=\"middle\" x=\"74\" y=\"-272.3\" font-family=\"Times,serif\" font-size=\"14.00\" fill=\"#ffffff\">Simple State Machine</text>
</g>
<!--Cosma-->
<g id=\"node2\" class=\"node\"><title>Cosma\\\SimpleStateMachine\\\States\\\Subst2</title>
<ellipse fill=\"#a8ce9f\" stroke=\"black\" cx=\"198\" cy=\"-276\" rx=\"32.0158\" ry=\"18\"/>
<text text-anchor=\"middle\" x=\"198\" y=\"-272.9\" font-family=\"Times,serif\" font-size=\"12.00\" fill=\"#000000\">Subst 2</text>
</g>
<!--Cosma-->
<g id=\"node3\" class=\"node\"><title>Cosma\\\SimpleStateMachine\\\States\\\Subst40</title>
<ellipse fill=\"#d3e3f5\" stroke=\"#8e949b\" cx=\"198\" cy=\"-18\" rx=\"35.5552\" ry=\"18\"/>
<text text-anchor=\"middle\" x=\"198\" y=\"-14.9\" font-family=\"Times,serif\" font-size=\"12.00\" fill=\"#000000\">Subst 40</text>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge1\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Subst2&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Subst40</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M188.951,-258.504C171.097,-223.723 134.91,-140.592 157,-74 160.847,-62.4027 168.195,-51.2675 175.621,-42.0866\"/>
<polygon fill=\"#8e949b\" stroke=\"#8e949b\" points=\"178.496,-44.111 182.364,-34.2473 173.189,-39.5463 178.496,-44.111\"/>
<text text-anchor=\"middle\" x=\"161.5\" y=\"-135.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\"> &gt; 50</text>
<polyline fill=\"none\" stroke=\"#000000\" points=\"171,-133 152,-133 150.986,-138.882 \"/>
</g>
<!--Cosma-->
<g id=\"node4\" class=\"node\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add5</title>
<ellipse fill=\"#d3e3f5\" stroke=\"#8e949b\" cx=\"315\" cy=\"-184\" rx=\"27.9777\" ry=\"18\"/>
<text text-anchor=\"middle\" x=\"315\" y=\"-180.9\" font-family=\"Times,serif\" font-size=\"12.00\" fill=\"#000000\">Add 5</text>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge7\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Subst2&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Add5</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M216.281,-260.938C236,-245.77 267.534,-221.513 289.643,-204.506\"/>
<polygon fill=\"#8e949b\" stroke=\"#8e949b\" points=\"291.818,-207.248 297.61,-198.377 287.55,-201.7 291.818,-207.248\"/>
<text text-anchor=\"start\" x=\"266\" y=\"-232.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\">Greater </text>
<text text-anchor=\"middle\" x=\"282\" y=\"-222.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\"> Than 20</text>
<polyline fill=\"none\" stroke=\"#000000\" points=\"298,-220 266,-220 272.52,-217.677 \"/>
</g>
<!--Cosma-->
<g id=\"node5\" class=\"node\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add20</title>
<ellipse fill=\"#d3e3f5\" stroke=\"#8e949b\" cx=\"198\" cy=\"-92\" rx=\"32.0158\" ry=\"18\"/>
<text text-anchor=\"middle\" x=\"198\" y=\"-88.9\" font-family=\"Times,serif\" font-size=\"12.00\" fill=\"#000000\">Add 20</text>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge10\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Subst2&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Add20</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M198,-257.878C198,-226.307 198,-158.673 198,-120.568\"/>
<polygon fill=\"#8e949b\" stroke=\"#8e949b\" points=\"201.5,-120.209 198,-110.209 194.5,-120.209 201.5,-120.209\"/>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge4\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add5&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Add20</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M297.736,-169.72C278.347,-154.805 246.661,-130.431 224.211,-113.163\"/>
<polygon fill=\"#8e949b\" stroke=\"#8e949b\" points=\"226.165,-110.25 216.105,-106.927 221.897,-115.798 226.165,-110.25\"/>
<text text-anchor=\"start\" x=\"266\" y=\"-140.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\">Less </text>
<text text-anchor=\"middle\" x=\"282\" y=\"-130.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\"> Than 30</text>
<polyline fill=\"none\" stroke=\"#000000\" points=\"298,-128 266,-128 272.47,-150.284 \"/>
</g>
<!--Cosma-->
<g id=\"node6\" class=\"node\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add15</title>
<ellipse fill=\"#d3e3f5\" stroke=\"#8e949b\" cx=\"380\" cy=\"-92\" rx=\"32.0158\" ry=\"18\"/>
<text text-anchor=\"middle\" x=\"380\" y=\"-88.9\" font-family=\"Times,serif\" font-size=\"12.00\" fill=\"#000000\">Add 15</text>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge5\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add5&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Add15</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M326.322,-167.323C336.266,-153.555 350.894,-133.301 362.369,-117.412\"/>
<polygon fill=\"#8e949b\" stroke=\"#8e949b\" points=\"365.352,-119.259 368.37,-109.103 359.678,-115.161 365.352,-119.259\"/>
<text text-anchor=\"start\" x=\"353\" y=\"-140.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\">Less </text>
<text text-anchor=\"middle\" x=\"369\" y=\"-130.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\"> Than 50</text>
<polyline fill=\"none\" stroke=\"#000000\" points=\"385,-128 353,-128 354.76,-127.948 \"/>
</g>
<!--Cosma-->
<g id=\"node7\" class=\"node\"><title>Cosma\\\SimpleStateMachine\\\States\\\Subst17</title>
<ellipse fill=\"#d3e3f5\" stroke=\"#8e949b\" cx=\"466\" cy=\"-92\" rx=\"35.5552\" ry=\"18\"/>
<text text-anchor=\"middle\" x=\"466\" y=\"-88.9\" font-family=\"Times,serif\" font-size=\"12.00\" fill=\"#000000\">Subst 17</text>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge6\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add5&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Subst17</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M337.88,-173.446C352.782,-166.918 372.456,-157.716 389,-148 406.526,-137.707 425.096,-124.517 439.607,-113.635\"/>
<polygon fill=\"#8e949b\" stroke=\"#8e949b\" points=\"441.796,-116.368 447.644,-107.533 437.563,-110.792 441.796,-116.368\"/>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge3\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add20&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Subst40</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M192.16,-73.937C191.275,-65.598 191.036,-55.3638 191.441,-45.9982\"/>
<polygon fill=\"#8e949b\" stroke=\"#8e949b\" points=\"194.938,-46.1682 192.173,-35.9405 187.956,-45.6601 194.938,-46.1682\"/>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge9\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add20&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Subst40</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M203.84,-73.937C204.725,-65.598 204.964,-55.3638 204.559,-45.9982\"/>
<polygon fill=\"#8e949b\" stroke=\"#8e949b\" points=\"208.044,-45.6601 203.827,-35.9405 201.062,-46.1682 208.044,-45.6601\"/>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge2\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add20&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Add20</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M229.737,-95.3742C239.925,-95.3396 248,-94.2148 248,-92 248,-89.7852 239.925,-88.6604 229.737,-88.6258\"/>
<text text-anchor=\"start\" x=\"248\" y=\"-94.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\">Less </text>
<text text-anchor=\"middle\" x=\"264\" y=\"-84.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\"> Than 30</text>
<polyline fill=\"none\" stroke=\"#000000\" points=\"280,-82 248,-82 247.994,-91.897 \"/>
</g>
<!--Cosma&#45;&gt;Cosma-->
<g id=\"edge8\" class=\"edge\"><title>Cosma\\\SimpleStateMachine\\\States\\\Add20&#45;&gt;Cosma\\\SimpleStateMachine\\\States\\\Add20</title>
<path fill=\"none\" stroke=\"#8e949b\" d=\"M228.338,-97.9157C252.904,-100.054 280,-98.082 280,-92 280,-85.918 252.904,-83.9461 228.338,-86.0843\"/>
<text text-anchor=\"start\" x=\"280\" y=\"-94.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\">Less </text>
<text text-anchor=\"middle\" x=\"296\" y=\"-84.8\" font-family=\"Times,serif\" font-size=\"9.00\" fill=\"#000000\"> Than 30</text>
<polyline fill=\"none\" stroke=\"#000000\" points=\"312,-82 280,-82 279.995,-91.8582 \"/>
</g>
</g>
</svg>
";

        $this->assertEquals($expectedSVG, $SVGExport, 'SVG export is wrong');
    }


    /**
     * @see Cosma\SimpleStateMachine\Graphic
     */
    public function testGraph_DOTGraphic()
    {
        $graphic = new Graphic('dot');

        $stateMachine = new StateMachine();

        $startState = new Subst2();
        $stateMachine->setState($startState);

        $DOTExport = $stateMachine->draw($graphic);

        $expectedDOT = "digraph G {
  \"Simple State Machine\" [color=\"#8E949B\" shape=\"box\" peripheries=2 fillcolor=\"pink2\" style=\"filled\" penwidth=1 fontcolor=\"#ffffff\" height=0 label=\"Simple State Machine\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Subst2\" [fillcolor=\"#A8CE9F\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Subst 2\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Subst40\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Subst 40\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add5\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Add 5\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add20\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Add 20\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add15\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Add 15\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Subst17\" [color=\"#8E949B\" fillcolor=\"#D3E3F5\" style=\"filled\" fontcolor=\"#000000\" fontsize=12 penwidth=1 label=\"Subst 17\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Subst2\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Subst40\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\" &gt; 50\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add20\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Add20\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\"Less \l Than 30\" dir=\"none\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add20\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Subst40\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 label=\"\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add5\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Add20\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\"Less \l Than 30\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add5\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Add15\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\"Less \l Than 50\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add5\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Subst17\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 label=\"\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Subst2\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Add5\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\"Greater \l Than 20\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add20\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Add20\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 labeldistance=3 labelangle=5 decorate=1 label=\"Less \l Than 30\" dir=\"none\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Add20\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Subst40\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 label=\"\"]
  \"Cosma\\\SimpleStateMachine\\\States\\\Subst2\" -> \"Cosma\\\SimpleStateMachine\\\States\\\Add20\" [color=\"#8E949B\" style=\"bold\" fontcolor=\"#000000\" fontsize=9 penwidth=1 label=\"\"]
}
";

        $this->assertEquals($expectedDOT, $DOTExport, 'DOT export is wrong');

    }

    /**
     * print_r("\n{$fromState->getId()}->{$toState->getId()}: {$label}\n\n\n");
     * @see Cosma\SimpleStateMachine\StateMachine
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