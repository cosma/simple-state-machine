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

namespace Cosma\SimpleStateMachine\Conditions;

use Cosma\SimpleStateMachine\AbstractCondition;
use Cosma\SimpleStateMachine\Price;

class LessThan50 extends AbstractCondition
{
    /**
     * @return string
     */
    public function getLabel()
    {
        return "Less \n Than 50";
    }

    /**
     * @return bool
     */
    public function isTrue()
    {
        /** @var Price $price */
        $price = $this->dataStructure;
        return $price->getValue() < 50.0;
    }
} 