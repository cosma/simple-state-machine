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
 * Time: 23:45
 */

namespace Cosma\SimpleStateMachine;


class Transition
{
    /**
     * Target State
     * @var AbstractState
     */
    private $state;

    /**
     * Condition to do transaction
     * @var AbstractCondition
     */
    private $condition;

    /**
     * DOT language attributes
     * @see http://www.graphviz.org/Documentation/dotguide.pdf
     *
     * @var array
     */
    public $styleAttributes = array(
        'color' => '#8E949B',
        'style' => 'bold',
        'fontcolor' => '#000000',
        'fontsize' => 9,
        'penwidth' => 1,

    );

    /**
     * @param AbstractState $state
     * @param AbstractCondition $condition
     */
    public function __construct(AbstractState $state, AbstractCondition $condition = null)
    {
        $this->state     = $state;
        $this->condition = $condition;
    }

    /**
     * @return AbstractCondition
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return AbstractState
     */
    public function getState()
    {
        return $this->state;
    }
} 