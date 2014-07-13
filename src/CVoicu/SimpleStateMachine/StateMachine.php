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

class StateMachine
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var AbstractState
     */
    private $state;

    /**
     * @var array AbstractState
     */
    private $statesHistory = array();

    /**
     * DOT language attributes
     * @see http://www.graphviz.org/Documentation/dotguide.pdf
     *
     * @var array
     */
    protected $styleAttributes = array(
        'color' => '#8E949B',
        'shape' => 'box',
        'peripheries' => 2,
        'fillcolor' => 'pink2',
        'style' => 'filled',
        'penwidth' => 1,
        'fontcolor' => '#ffffff',
        'height' => .0,
    );

    /**
     * @param string $label
     */
    public function __construct($label = 'Simple State Machine')
    {
        $this->label = $label;
    }

    /**
     * @param AbstractState $state
     */
    public function setState(AbstractState $state)
    {
        $state->setStateMachine($this);

        $this->state = $state;
    }

    /**
     * @return AbstractState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        if($this->state instanceof AbstractState){
            $this->state->run();
        }else{
            throw new \Exception('State is not Set!');
        }
    }

    /**
     * @throws \Exception
     */
    public function draw(AbstractGraphic $graphic)
    {
        $graphic->drawLegend($this->label, $this->styleAttributes);

        if($this->state instanceof AbstractState){
            $this->state->draw($graphic);
        }else{
            throw new \Exception('State is not Set!');
        }

        return $graphic->export();
    }

    /**
     * @param AbstractState $state
     */
    public function addStateToHistory(AbstractState $state)
    {
        $this->statesHistory[] = $state;
    }

    /**
     * @return array
     */
    public function getStatesHistory()
    {
        return $this->statesHistory;
    }
} 