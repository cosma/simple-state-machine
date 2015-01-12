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
 * Time: 02:18
 */

namespace Cosma\SimpleStateMachine\Example;


use Cosma\SimpleStateMachine\DataInterface;

class Price implements DataInterface
{
    /**
     * @var float
     */
    private  $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    private $traces = array();

    /**
     * @param $trace
     */
    public function addTrace($trace)
    {
        $this->traces[] = $trace;
    }

    /**
     * @return array
     */
    public function getTraces()
    {
        return $this->traces;
    }
} 