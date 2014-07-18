<?php
/**
 * This file is part of the "SimpleStateMachine" project
 *
 * (c) Cosmin Voicu<cosmin.voicu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 13/07/14
 * Time: 05:11
 */

namespace Cosma\SimpleStateMachine;


abstract class AbstractGraphic
{

    /**
     * @see http://en.wikipedia.org/wiki/DOT_(graph_description_language)
     *
     * Format of the generated image.
     * Can be: svg, png, jpeg, ... plus DOT (graph description language)
     *
     * @var string
     */
    protected $format;

    /**
     * @var mixed
     */
    protected $graph;

    /**
     * @var array
     */
    protected $statesStorage = array();

    /**
     * @var array
     */
    protected $transitionsStorage = array();

    /**
     * @var array
     */
    protected $legendsStorage = array();


    /**
     * @param string $format
     */
    public function __construct($format = 'svg')
    {
        $this->format = $format;
        $this->setGraph();
    }

    /**
     * set the Graph DTO adapter
     * @return mixed
     */
    abstract protected function setGraph();

    /**
     * Draw Legend
     *
     * @param $text
     * @param array $styleAttributes
     * @return mixed
     */
    abstract public function addLegend($text, $styleAttributes = array());

    /**
     * Draw a State
     *
     * @param $state
     * @param $label
     * @param array $styleAttributes
     * @return mixed
     */
    abstract public function addState($state, $label, $styleAttributes = array());

    /**
     * Draw a Transition
     *
     * @param $fromState
     * @param $toState
     * @param $label
     * @param array $styleAttributes
     * @return mixed
     */
    abstract public function addTransition($fromState, $toState, $label, $styleAttributes = array());

    /**
     * Export the Graph drawing
     * @return mixed
     */
    abstract public function export();
} 