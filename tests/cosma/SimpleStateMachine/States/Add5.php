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

namespace  cosma\SimpleStateMachine\States;

use cosma\SimpleStateMachine\AbstractState;
use cosma\SimpleStateMachine\Price;

class Add5 extends AbstractState
{
    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Add 5';
    }

    /**
     * @return mixed|void
     */
    protected function processDataStructure()
    {
        /** @var Price $price */
        $price = $this->getDataStructure();
        $price->setValue($price->getValue() + 5);
    }

    protected function configureAvailableTransitions()
    {
        $this->addTransition('cosma\SimpleStateMachine\States\Add20', 'cosma\SimpleStateMachine\Conditions\LessThan30');
        $this->addTransition('cosma\SimpleStateMachine\States\Add15', 'cosma\SimpleStateMachine\Conditions\LessThan50');
        $this->addTransition('cosma\SimpleStateMachine\States\Subst17');

    }
} 