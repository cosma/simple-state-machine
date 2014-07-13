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
    protected $dataStructure = null;

    /**
     * @var array
     */
    protected $styleAttributes = array(
        'style' => 'filled',
        'penwidth' => 1,
        'fontcolor' => '#000000',
        'fontsize' => 10,
    );

    /**
     * @param InterfaceDataStructure $dataStructure
     */
    public function __construct(InterfaceDataStructure $dataStructure = null)
    {
        $this->dataStructure = $dataStructure;
    }

    /**
     * Label of this Condition
     *
     * @return string
     */
    abstract public function getLabel();

    /**
     *  Check if this condition is true
     *
     * @return bool
     */
    abstract public function isTrue();

    /**
     * @param array $styleAttributes
     */
    public function setStyleAttributes($styleAttributes)
    {
        $this->styleAttributes = $styleAttributes;
    }

    /**
     * @return array
     */
    public function getStyleAttributes()
    {
        return $this->styleAttributes;
    }
} 