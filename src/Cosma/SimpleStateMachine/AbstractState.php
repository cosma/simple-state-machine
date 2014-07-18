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

namespace Cosma\SimpleStateMachine;


abstract class AbstractState
{
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

    /**
     * DOT language attributes
     * @see http://www.graphviz.org/Documentation/dotguide.pdf
     *
     * @var array
     */
    protected $styleAttributes = array(
        'color' => '#8E949B',
        'fillcolor' => '#D3E3F5',
        'style' => 'filled',
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
        $this->configureAvailableTransitions();

        $this->stateMachine->setState($this);
        $this->processDataStructure();
        $this->stateMachine->addStateToHistory($this);
        $this->doTransition();

    }

    /**
     * Draw this State
     *
     * @param AbstractGraphic $graphic
     * @param bool $propagation
     * @return mixed
     * @throws \Exception
     */
    public function draw(AbstractGraphic $graphic, $propagation = true)
    {

        if( 0 == strlen(trim($this->getLabel())))
        {
            throw new \Exception("Label cannot be empty!");
        }

        $this->configureAvailableTransitions();

        $drawnState = $graphic->addState($this->getId(), $this->getLabel(), $this->styleAttributes);

        if($propagation){
            /** @var Transition $transition */
            foreach($this->availableTransitions as $transition)
            {
                $nextState = $transition->getState();
                if($this->getId() == $nextState->getId()){
                    $propagation = false;
                }

                $drawnNextState = $nextState->draw($graphic, $propagation);

                $label = '';
                $styleAttributes = $transition->styleAttributes;
                if($transition->getCondition() instanceof AbstractCondition){
                    $label = $transition->getCondition()->getLabel();
                    $styleAttributes = $transition->getCondition()->getStyleAttributes();
                }

                $graphic->addTransition(
                    $drawnState,
                    $drawnNextState,
                    $label,
                    $styleAttributes
                );
            }
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

} 