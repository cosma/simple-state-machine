<?php
/**
 * This file is part of the "SimpleStateMachine" project
 *
 * (c) Cosmin Voicu<cosmin.voicu@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 18/07/14
 * Time: 22:35
 */

namespace Cosma\SimpleStateMachine\Tests\Example\States;

use Cosma\SimpleStateMachine\AbstractState;

class EmptyLabelState extends AbstractState
{
    /**
     * @return string
     */
    public function getLabel()
    {
        return '';
    }

    /**
     * @return mixed|void
     */
    protected function process()
    {}

    /**
     * @return mixed|void
     */
    protected function configureAvailableTransitions()
    {}
} 