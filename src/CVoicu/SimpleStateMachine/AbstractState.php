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
 * Time: 23:41
 */

namespace CVoicu\SimpleStateMachine;


abstract class AbstractState {

    /**
     * @var InterfaceDataStructure
     */
    private $dataStructure;

    /**
     * Available Transitions from this State
     *
     * @var array Transition
     */
    private $availableTransitions = array();

    /**
     * @param InterfaceDataStructure $dataStructure
     */
    public function __construct(InterfaceDataStructure $dataStructure)
    {
        $this->dataStructure = $dataStructure;
        $this->configureAvailableTransitions();
    }

    /**
     * Label of this State
     *
     * @return string
     */
    abstract public function getLabel();

    /**
     * State specific transformation over DataStructure
     *
     * @return mixed
     */
    abstract protected function processDataStructure();

    /**
     * Configure available Transitions to another States.
     *
     * @return mixed
     */
    abstract protected function configureAvailableTransitions();

    /**
     * Run this state
     *
     * @param StateMachine $stateMachine
     */
    public function run(StateMachine $stateMachine)
    {
        $this->updateStateMachineToCurrentState($stateMachine);
        $this->processDataStructure();
        $this->doTransition($stateMachine);

    }

    /**
     * Draw this state and
     *
     * @param StateMachine $stateMachine
     */
    public function draw(StateMachine $stateMachine)
    {
        $stateMachine->getGraphic()->addState($this->getId(), $this->getLabel());

        /** @var Transition $transition */
        foreach($this->availableTransitions as $transition)
        {
            if($transition->getCondition() instanceof AbstractCondition){
                if($transition->getCondition()->isTrue()){
                    $transition->getState()->run($stateMachine);
                    break;
                }
                continue;
            }
            $transition->getState()->run($stateMachine);
            break;
        }

    }

    /**
     * @param StateMachine $stateMachine
     */
    private function updateStateMachineToCurrentState(StateMachine $stateMachine)
    {
        $stateMachine->setState($this);
        $stateMachine->addStateToHistory($this);
    }

    /**
     * Get available Transition and iterates through them and forward to a new State is the Condition is true
     *
     * @param StateMachine $stateMachine
     */
    private function doTransition(StateMachine $stateMachine)
    {
        /** @var Transition $transition */
        foreach($this->availableTransitions as $transition)
        {
            if($transition->getCondition() instanceof AbstractCondition){
                if($transition->getCondition()->isTrue()){
                    $transition->getState()->run($stateMachine);
                    break;
                }
                continue;
            }
            $transition->getState()->run($stateMachine);
            break;
        }
    }

    /**
     * Return the Id of this State
     *
     * @return string
     */
    protected function getId()
    {
        return get_class($this);
    }

    /**
     * Add Transition to a new State with an optional Condition
     *
     * @param AbstractState $newState
     * @param AbstractCondition $conditionToNewState
     */
    public function addTransition(AbstractState $newState, AbstractCondition $conditionToNewState = null)
    {
        $this->availableTransitions[] = new Transition($newState, $conditionToNewState);
    }

    /**
     * @return InterfaceDataStructure
     */
    public function getDataStructure()
    {
        return $this->dataStructure;
    }
} 