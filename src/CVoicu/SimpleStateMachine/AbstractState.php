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
     * The State Machine
     *
     * @var StateMachine
     */
    private $stateMachine = null ;

    /**
     * Available Transitions from this State
     *
     * @var array Transition
     */
    private $availableTransitions = array();

    protected $styleAttributes = array(
        'fillcolor' => '#B9D1E0',
        'style' => 'filled',
        'penwidth' => 1,
        'fontcolor' => '#000000',
        'fontsize' => 12,
        'penwidth' => 1,
    );

    /**
     * @param InterfaceDataStructure $dataStructure
     */
    public function __construct(InterfaceDataStructure $dataStructure = null)
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
     */
    public function run()
    {
        $this->stateMachine->setState($this);
        $this->processDataStructure();
        $this->stateMachine->addStateToHistory($this);
        $this->doTransition();

    }

    /**
     * Draw this state
     *
     * @param AbstractGraphic $graphic
     * @return mixed
     */
    public function draw(AbstractGraphic $graphic)
    {
        $drawnState = $graphic->drawState($this->getId(), $this->getLabel(), $this->styleAttributes);

        /** @var Transition $transition */
        foreach($this->availableTransitions as $transition)
        {
            $nextState = $transition->getState()->draw($graphic);

            $label = '';
            $styleAttributes = array();
            if($transition->getCondition() instanceof AbstractCondition){
                $label = $transition->getCondition()->getLabel();
                $styleAttributes = $transition->getCondition()->getStyleAttributes();
            }

            $graphic->drawTransition(
                $drawnState,
                $nextState,
                $label,
                $styleAttributes
            );
        }
        return $drawnState;
    }

    /**
     * Get available Transition , iterates through them and forward to a new State if the Condition is true
     */
    private function doTransition()
    {
        /** @var Transition $transition */
        foreach($this->availableTransitions as $transition)
        {
            if($transition->getCondition() instanceof AbstractCondition){
                if($transition->getCondition()->isTrue()){
                    $transition->getState()->setStateMachine($this->stateMachine);
                    $transition->getState()->run();
                    break;
                }
                continue;
            }
            $transition->getState()->setStateMachine($this->stateMachine);
            $transition->getState()->run();
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
     * @param StateMachine $stateMachine
     */
    public function setStateMachine(StateMachine $stateMachine = null)
    {
        $this->stateMachine = $stateMachine;
    }

    /**
     * @return StateMachine
     */
    public function getStateMachine()
    {
        return $this->stateMachine;
    }

    /**
     * Add Transition to a new State with an optional Condition
     *
     * @param $newStateClassName
     * @param null $conditionClassName
     * @throws \Exception
     */
    public function addTransition($newStateClassName, $conditionClassName = null)
    {

        try{
            if(!class_exists($newStateClassName)){
                throw new \Exception();
            }
            /** @var AbstractState $newState */
            $newState = new $newStateClassName($this->getDataStructure());
            $newState->setStateMachine($this->stateMachine);

            $condition = null;
            if($conditionClassName){
                if(!class_exists($conditionClassName)){
                    throw new \Exception();
                }
                /** @var AbstractCondition $condition */
                $condition = new $conditionClassName($this->getDataStructure());
            }
        } catch(\Exception $e){
            throw new \Exception(
                "Cannot load Transition from State '{$this->getId()}' ".
                " --> to State '{$newStateClassName}'".
                " with Condition '{$conditionClassName}' : {$e->getMessage()} "
            );
        }

        $this->availableTransitions[] = new Transition($newState, $condition);
    }

    /**
     * @return InterfaceDataStructure
     */
    public function getDataStructure()
    {
        return $this->dataStructure;
    }

    /**
     * @param array $styleAttributes
     */
    public function setStyleAttributes($styleAttributes)
    {
        $this->styleAttributes = $styleAttributes;
    }

    /**
     * @return array
     */
    public function getStyleAttributes()
    {
        return $this->styleAttributes;
    }
} 