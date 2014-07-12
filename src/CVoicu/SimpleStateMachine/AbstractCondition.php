<?php
/**
 * This file is part of the "SimpleStateMachine" project
 *
 * (c) Cosmin Voicu<cosmin.voicu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 11/07/14
 * Time: 23:42
 */

namespace CVoicu\SimpleStateMachine;


abstract class AbstractCondition
{
    /**
     * @var InterfaceDataStructure
     */
    private $dataStructure;

    /**
     * @param InterfaceDataStructure $dataStructure
     */
    public function __construct(InterfaceDataStructure $dataStructure)
    {
        $this->dataStructure = $dataStructure;
    }

    /**
     * @return bool
     */
    abstract public function isTrue();
} 