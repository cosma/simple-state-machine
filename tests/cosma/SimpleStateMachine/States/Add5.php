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

namespace  Cosma\SimpleStateMachine\States;

use Cosma\SimpleStateMachine\AbstractState;
use Cosma\SimpleStateMachine\Price;

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
        $this->addTransition('Cosma\SimpleStateMachine\States\Add20', 'Cosma\SimpleStateMachine\Conditions\LessThan30');
        $this->addTransition('Cosma\SimpleStateMachine\States\Add15', 'Cosma\SimpleStateMachine\Conditions\LessThan50');
        $this->addTransition('Cosma\SimpleStateMachine\States\Subst17');

    }
} 