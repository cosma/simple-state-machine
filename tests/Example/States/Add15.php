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

namespace Cosma\SimpleStateMachine\Tests\Example\States;

use Cosma\SimpleStateMachine\AbstractState;
use Cosma\SimpleStateMachine\Tests\Example\Price;

class Add15 extends AbstractState
{
    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Add 15';
    }

    /**
     * @return mixed|void
     */
    protected function process()
    {
        /** @var Price $price */
        $price = $this->getData();
        $price->setValue($price->getValue() +15);
    }

    protected function configureAvailableTransitions()
    {}
} 