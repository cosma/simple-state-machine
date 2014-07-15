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

namespace Cosma\SimpleStateMachine;


abstract class AbstractCondition
{
    /**
     * @var InterfaceDataStructure
     */
    protected $dataStructure = null;

    /**
     * DOT language attributes
     * @see http://www.graphviz.org/Documentation/dotguide.pdf
     *
     * @var array
     */
    protected $styleAttributes = array(
        'color' => '#8E949B',
        'style' => 'bold',
        'fontcolor' => '#000000',
        'fontsize' => 9,
        'penwidth' => 1,
        'labeldistance' => 3,
        'labelangle' => 5,
        'decorate' => true,
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