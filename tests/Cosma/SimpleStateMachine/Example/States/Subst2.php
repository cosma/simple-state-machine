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

namespace Cosma\SimpleStateMachine\Example\States;

use Cosma\SimpleStateMachine\AbstractState;
use Cosma\SimpleStateMachine\Example\Price;

class Subst2 extends AbstractState
{
    /**
     * @var array
     */
    protected $styleAttributes = array(
        'fillcolor' => '#A8CE9F',
        'style' => 'filled',
        'fontcolor' => '#000000',
        'fontsize' => 12,
        'penwidth' => 1,
    );

    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Subst 2';
    }

    /**
     * @return mixed|void
     */
    protected function process()
    {
        /** @var Price $price */
        $price = $this->getData();
        $price->setValue($price->getValue() - 2);
    }

    protected function configureAvailableTransitions()
    {

        $this->addTransition('Cosma\SimpleStateMachine\Example\States\Subst40', 'Cosma\SimpleStateMachine\Example\Conditions\GreaterThan50');
        $this->addTransition('Cosma\SimpleStateMachine\Example\States\Add5', 'Cosma\SimpleStateMachine\Example\Conditions\GreaterThan20');
        $this->addTransition('Cosma\SimpleStateMachine\Example\States\Add20');
    }
} 