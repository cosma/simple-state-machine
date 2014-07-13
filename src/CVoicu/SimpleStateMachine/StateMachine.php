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
     * Represents graphical the State Machine
     * @var Graphic
     */
    private $graphic;

    protected $styleAttributes = array(

    );

    /**
     * @param string $name
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
    public function draw()
    {
        if($this->state instanceof AbstractState){
            $this->state->draw($this);
        }else{
            throw new \Exception('State is not Set!');
        }
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

    /**
     * @param Graphic  $graphic
     */
    public function setGraphic(Graphic $graphic)
    {
        $this->graphic = $graphic;
    }

    /**
     * @return Graphic
     */
    public function getGraphic()
    {
        return $this->graphic;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
} 