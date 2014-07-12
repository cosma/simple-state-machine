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
     * @var array Transition
     */
    private $transitions = array();

    /**
     * @var InterfaceDataStructure
     */
    private $dataStructure;

    /**
     * @var StateMachine
     */
    private $stateMachine;

    public function __construct(InterfaceDataStructure $dataStructure)
    {
        $this->dataStructure = $dataStructure;
    }

    /**
     * State specific process of DataStructure
     *
     * @return mixed
     */
    abstract protected function processDataStructure();

    /**
     * Configure transitions to another states.
     *
     * @return mixed
     */
    abstract protected function configureTransitions();

    /**
     * @param StateMachine $stateMachine
     */
    public function run(StateMachine $stateMachine)
    {
        $this->updateStateMachineToCurrentState($stateMachine);
        $this->processDataStructure();
        $this->doTransition($stateMachine);

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
     * @param StateMachine $stateMachine
     */
    private function doTransition(StateMachine $stateMachine)
    {
        $this->configureTransitions();

        /** @var Transition $transition */
        foreach($this->transitions as $transition)
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
     * @return string
     */
    public function getName()
    {
        return get_class($this);
    }

    /**
     * @param AbstractState $newState
     * @param AbstractCondition $conditionToNewState
     *
     * @return $this
     */
    public function addTransition(AbstractState $newState, AbstractCondition $conditionToNewState = null)
    {
        try{
            $this->transitions[] = new Transition($newState, $conditionToNewState);
        } catch(\Exception $e){
            "Transition could not be defined between: {$this->getName()} and {$conditionToNewState->getName()}" ;
        }
        return $this;
    }

    /**
     * @return InterfaceDataStructure
     */
    public function getDataStructure()
    {
        return $this->dataStructure;
    }
} 