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


class StateMachine {

    /**
     * @var AbstractState
     */
    private $state;

    /**
     * @var array AbstractState
     */
    private $statesHistory;

    /**
     * @param AbstractState $state
     */
    public function setState($state)
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
     * @param AbstractState $startState
     */
    public function run(AbstractState $startState)
    {
        $startState->run($this);
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