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
 * Time: 23:33
 */

namespace CVoicu\SimpleStateMachine;

class Graphic
{

    public function addLegend($text)
    {
        echo "\n addLegend {$text} \n";

    }

    public function addState($state, $label, $styleAttributes = array())
    {
        echo "\n addState {$label} \n";

    }

    public function addTransition($fromState, $toState, $condition, $label, $styleAttributes = array())
    {
        echo "\n addState {$fromState} -  {$toState} - {$condition} \n";

    }


    public function addCopyRight()
    {
        echo "\nadd copyright \n";
    }



} 