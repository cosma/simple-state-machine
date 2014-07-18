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
     * @param $label
     * @param array $styleAttributes
     * @return Layoutable|mixed
     */
    public function drawLegend($label, $styleAttributes = array())
    {
        $styleAttributes['label'] = $label;
        return $this->graph->createVertex($label, true)->setLayout($styleAttributes);
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
        $vertex = $this->graph->createVertex($state, true);
        $vertex->setLayout($styleAttributes);

        return $vertex;
    }

    /**
     * @param $fromState
     * @param $toState
     * @param $label
     * @param array $styleAttributes
     * @return Directed|mixed
     */
    public function drawTransition($fromState, $toState, $label, $styleAttributes = array())
    {
        $styleAttributes['label'] = $label;
        /** @var Vertex $fromState */
        /** @var Vertex $toState */
        $edge = $fromState->createEdgeTo($toState);
        $edge->setLayout($styleAttributes);
        return $edge;

    }

    /**
     * Export to desired format
     *
     * @return mixed|string
     */
    public function export()
    {
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