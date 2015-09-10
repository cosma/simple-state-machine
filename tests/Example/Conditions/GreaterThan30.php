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
 * Time: 12:04
 */

namespace Cosma\SimpleStateMachine\Tests\Example\Conditions;

use Cosma\SimpleStateMachine\AbstractCondition;
use Cosma\SimpleStateMachine\Tests\Example\Price;

class GreaterThan30 extends AbstractCondition
{
    /**
     * @return string
     */
    public function getLabel()
    {
        return "Greater \n Than 30";
    }

    /**
     * @return bool
     */
    public function isTrue()
    {
        /** @var Price $price */
        $price = $this->data;
        return $price->getValue() > 30.0;
    }
} 