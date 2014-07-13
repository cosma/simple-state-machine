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

namespace  CVoicu\SimpleStateMachine\States;

use CVoicu\SimpleStateMachine\AbstractState;
use CVoicu\SimpleStateMachine\Price;

class Add5 extends AbstractState
{
    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Add5';
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

    }
} 