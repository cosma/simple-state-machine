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

namespace Cosma\SimpleStateMachine\Example\Conditions;

use Cosma\SimpleStateMachine\AbstractCondition;
use Cosma\SimpleStateMachine\Price;

class GreaterThan10 extends AbstractCondition
{
    /**
     * @return string
     */
    public function getLabel()
    {
        return "Greater \n Than 10";
    }

    /**
     * @return bool
     */
    public function isTrue()
    {
        /** @var Price $price */
        $price = $this->dataStructure;
        return $price->getValue() > 10.0;
    }
} 