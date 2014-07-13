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

namespace CVoicu\SimpleStateMachine\States;

use CVoicu\SimpleStateMachine\AbstractState;
use CVoicu\SimpleStateMachine\Conditions\GreaterThan20;
use CVoicu\SimpleStateMachine\Conditions\GreaterThan50;
use CVoicu\SimpleStateMachine\Price;

class Subst2 extends AbstractState
{
    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Subst2';
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

        $this->addTransition('CVoicu\SimpleStateMachine\States\Subst40', 'CVoicu\SimpleStateMachine\Conditions\GreaterThan50');

        $this->addTransition('CVoicu\SimpleStateMachine\States\Add5', 'CVoicu\SimpleStateMachine\Conditions\GreaterThan20');

        $this->addTransition('CVoicu\SimpleStateMachine\States\Add20');

    }
} 