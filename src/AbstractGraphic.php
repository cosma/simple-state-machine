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
     * Legends storage
     *
     * @var array
     */
    protected $legendsStorage = array();

    /**
     * States storage
     *
     * @var array
     */
    protected $statesStorage = array();

    /**
     * Transitions storage
     *
     * @var array
     */
    protected $transitionsStorage = array();

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
     *
     * @return mixed
     */
    abstract protected function setGraph();

    /**
     * Export the Graph drawing
     * @return mixed
     */
    abstract public function draw();

    /**
     * Add Legend
     *
     * @param $label
     * @param array $styleAttributes
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function addLegend($label, $styleAttributes = array())
    {
        if(empty($label))
        {
            throw new \InvalidArgumentException('Legend\'s Label cannot be empty.');
        }

        if(!array_key_exists($label, $this->legendsStorage))
        {
            $styleAttributes['label'] = $label;
            $this->legendsStorage[$label] = $styleAttributes;
        }
        return $label;
    }

    /**
     * Add State
     *
     * @param $id
     * @param $label
     * @param array $styleAttributes
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function addState($id, $label, $styleAttributes = array())
    {
        if(empty($id))
        {
            throw new \InvalidArgumentException('State\'s Id cannot be empty.');
        }

        if(empty($label))
        {
            throw new \InvalidArgumentException('State\'s Label cannot be empty.');
        }

        if(!array_key_exists($id, $this->statesStorage))
        {
            $styleAttributes['label'] = $label;
            $this->statesStorage[$id] = $styleAttributes;
        }
        return $id;
    }

    /**
     * Add Transition
     *
     * @param $fromStateId
     * @param $targetStateId
     * @param $label
     * @param array $styleAttributes
     * @return string
     * @throws \InvalidArgumentException
     */
    public function addTransition($fromStateId, $targetStateId, $label, $styleAttributes = array())
    {
        if(empty($fromStateId))
        {
            throw new \InvalidArgumentException('Transition\'s From State cannot be empty');
        }

        if(empty($targetStateId))
        {
            throw new \InvalidArgumentException('Transition\'s Target State cannot be empty');
        }

        $transitionId = "{$fromStateId}---->{$targetStateId}";

        if(!array_key_exists($transitionId, $this->transitionsStorage))
        {
            $styleAttributes['label'] = $label;

            $this->transitionsStorage[$transitionId] = array(
                'fromStateId' => $fromStateId,
                'targetStateId' => $targetStateId,
                'styleAttributes' => $styleAttributes
            );
        }
        return $transitionId;
    }

    public function isDOTInstalled() {
        $returnValue = shell_exec("which dot");
        return (empty($returnValue) ? false : true);
    }
}
