<?php
/**
 * This file is part of the "SimpleStateMachine" project
 *
 * (c) Cosmin Voicu<cosmin.voicu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 12/07/14
 * Time: 02:16
 */

namespace cosma\SimpleStateMachine\States;

use cosma\SimpleStateMachine\AbstractState;
use cosma\SimpleStateMachine\Price;

class Subst2 extends AbstractState
{
    /**
     * @var array
     */
    protected $styleAttributes = array(
        'fillcolor' => '#A8CE9F',
        'style' => 'filled',
        'fontcolor' => '#000000',
        'fontsize' => 12,
        'penwidth' => 1,
    );

    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Subst 2';
    }

    /**
     * @return mixed|void
     */
    protected function processDataStructure()
    {
        /** @var Price $price */
        $price = $this->getDataStructure();
        $price->setValue($price->getValue() - 2);
    }

    protected function configureAvailableTransitions()
    {
        $this->addTransition('cosma\SimpleStateMachine\States\Add5', 'cosma\SimpleStateMachine\Conditions\GreaterThan20');
        $this->addTransition('cosma\SimpleStateMachine\States\Subst40', 'cosma\SimpleStateMachine\Conditions\GreaterThan50');
        $this->addTransition('cosma\SimpleStateMachine\States\Add20');
    }
} 