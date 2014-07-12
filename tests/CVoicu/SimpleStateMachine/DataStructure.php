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

namespace tests;


use CVoicu\SimpleStateMachine\InterfaceDataStructure;

class DataStructure implements InterfaceDataStructure
{
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