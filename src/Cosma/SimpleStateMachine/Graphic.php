<?php
/**
 * This file is part of the "SimpleStateMachine" project
 *
 * (c) Cosmin Voicu<cosmin.voicu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 11/07/14
 * Time: 23:33
 */

namespace Cosma\SimpleStateMachine;

use Fhaculty\Graph\Edge\Directed;
use Fhaculty\Graph\Exporter\Dot;
use Fhaculty\Graph\Exporter\Image;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Layoutable;
use Fhaculty\Graph\Vertex;

class Graphic extends AbstractGraphic
{
    /**
     * @var Graph
     */
    protected $graph;

    /**
     * @return mixed|void
     */
    protected function setGraph()
    {
        $this->graph = new Graph();
    }

    /**
     * Draw all Legends
     *
     * @return array
     */
    private function drawLegends()
    {
        $legends = array();

        foreach($this->legendsStorage as $id => $legend){
            $legends[] = $this->graph->createVertex($id, true)->setLayout($legend);
        }
        return $legends;
    }

    /**
     * Draw all States
     *
     * @return array
     */
    public function drawStates()
    {
        $states = array();

        foreach($this->statesStorage as $id => $state){
            $states[] = $this->graph->createVertex($id, true)->setLayout($state);
        }
        return $states;
    }

    /**
     * Draw all Transitions
     *
     * @return array
     */
    public function drawTransitions()
    {
        $transitions = array();

        foreach($this->transitionsStorage as $transition){

            $fromState = $this->graph->createVertex($transition['fromStateId'], true);
            $targetState = $this->graph->createVertex($transition['targetStateId'], true);
            $edge = $fromState->createEdgeTo($targetState)->setLayout($transition['styleAttributes']);

            $transitions[] = $edge;
        }
        return $transitions;

    }

    /**
     * Draw to desired format
     *
     * @return mixed|string
     */
    public function draw()
    {



        $this->drawLegends();
        $this->drawStates();
        $this->drawTransitions();

        if("dot" == $this->format)
        {
            $exporter = new Dot();
        }else{
            $exporter = new Image();
            $exporter->setFormat($this->format);
        }
        return $exporter->getOutput($this->graph);
    }
} 