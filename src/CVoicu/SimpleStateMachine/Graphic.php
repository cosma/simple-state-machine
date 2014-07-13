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

namespace CVoicu\SimpleStateMachine;

use Fhaculty\Graph\Edge\Directed;
use Fhaculty\Graph\Exporter\Image;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;

class Graphic extends AbstractGraphic
{
    /**
     * @var Graph
     */
    protected $graph;


    protected function setGraph()
    {
        $this->graph = new Graph();
    }

    public function drawLegend($label, $styleAttributes = array())
    {
        $styleAttributes['label'] = $label;
        return $this->graph->createVertex($label.time())->setLayout($styleAttributes);

    }

    /**
     * @param $state
     * @param $label
     * @param array $styleAttributes
     * @return Vertex|mixed
     */
    public function drawState($state, $label, $styleAttributes = array())
    {
        $styleAttributes['label'] = $label;
        $vertex = $this->graph->createVertex($state);
        $vertex->setLayout($styleAttributes);

        return $vertex;

    }

    /**
     * @param $initialState
     * @param $nextState
     * @param $label
     * @param array $styleAttributes
     * @return Directed|mixed
     */
    public function drawTransition($initialState,$nextState, $label, $styleAttributes = array())
    {
        $styleAttributes['label'] = $label;
        /** @var Vertex $initialState */
        /** @var Vertex $nextState */
        $edge = $initialState->createEdgeTo($nextState);
        $edge->setLayout($styleAttributes);
        return $edge;

    }


    public function export()
    {
        $exporter = new Image();
        $exporter->setFormat($this->format);
        return $exporter->getOutput($this->graph);

    }
} 