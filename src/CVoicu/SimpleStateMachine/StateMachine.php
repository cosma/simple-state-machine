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
    private $name;

    /**
     * @var AbstractState
     */
    private $state;

    /**
     * @var array AbstractState
     */
    private $statesHistory;

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
    public function __construct($name = 'Simple State Machine')
    {
        $this->name = $name;
    }

    /**
     * @param AbstractState $state
     */
    public function setState(AbstractState $state)
    {
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
            $this->state->run($this);
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
} 