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
 * Time: 01:52
 */

namespace tests;

use CVoicu\SimpleStateMachine\StateMachine;


class StateMachineTest extends \PHPUnit_Framework_TestCase
{

    public function testStateMachine()
    {

        $stateMachine = new StateMachine();
        print_r($stateMachine);
    }


}