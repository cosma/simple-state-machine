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

namespace cosma\SimpleStateMachine\Conditions;

use cosma\SimpleStateMachine\AbstractCondition;
use cosma\SimpleStateMachine\Price;

class GreaterThan20 extends AbstractCondition
{
    /**
     * @return string
     */
    public function getLabel()
    {
        return "Greater \n Than 20";
    }

    /**
     * @return bool
     */
    public function isTrue()
    {
        /** @var Price $price */
        $price = $this->dataStructure;
        return $price->getValue() > 20.0;
    }
} 