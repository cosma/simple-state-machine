SimpleStateMachine -  A very simple State Machine  [![Build Status](https://drone.io/bitbucket.org/cosma/simplestatemachine/status.png)](https://drone.io/bitbucket.org/cosma/simplestatemachine/latest)
=================================================

A Simple State Machine without persistent states.
A DataEntry object will just go thru different state without timeouts.
The State Machine structure can be visualised in a UML diagram



## Installation ##

This is installable via [Composer](https://getcomposer.org/) as [cosma/simplesStateMachine](https://packagist.org/packages/cosma/simplesStateMachine).

## Table of Contents

- [Usage](#usage)
- [Reference](#reference)
  - [Defining States](#defining-states)
  - [Configure Transitions](#configure-transitions)
  - [Define Conditions](#define-conditions)
  - [DOT Language](#dot-language)

## Usage ##


To use the State machine

Examples:

```php

$stateMachine = \cosma\SimpleStateMachine\StateMachine();

$initialDataStructure = new \YourBundle\DataStructure();
$startState = \YourBundle\StateMachineProcess\States\StartState($dataStucture);

$stateMachine->setState($startState);
$stateMachine->run();

$finalDataStructure = $stateMachine->getCurrentState()->getDataStructure();
```

Note: You can also pass an array of filenames if you have multiple files with
references spanning more than one.

> **Note**: To load plain PHP files, you can use the `dsaadad`
> class instead. These PHP files must return an array containing the same
> structure as the  files have.

## Reference ##

### Defining States ###

Example of a state

```php
namespace \YourBundle\StateMachineProcess\States\SomeState;

class SomeState extends \cosma\SimpleStateMachine\Abstract\State
{
    /**
    *   process that modifies the DataStructure in this state
    */
    protected process()
    {
        $this->getDataStructure->doSomething()
    }

    ....
}
```

This works fine, but it is not very powerful and is completely static. You
still have to do most of the work. Let's see how to make this more interesting.

### Configure Transitions ###

To link states is very easy

```php

namespace  \YourBundle\StateMachineProcess\States\SomeState;

class SomeState extends \cosma\SimpleStateMachine\Abstract\State
{
    protected process()
    {
       ....
    }

    /**
    *   configure forward to another states
    */
    protected configureTransitions()
    {
       $this->addTransition(new \YourBundle\StateMachineProcess\States\AnotherState($this->getDataStricture()));

       .
       .
       .

       $this->addTransition(
           new \YourBundle\StateMachineProcess\States\LastState($this->getDataStricture()),
           new \YourBundle\StateMachineProcess\Conditions\ConditionToLastState($this->getDataStricture())
       );
    }
}
```

### Defining Conditions ###

A transition between states is possible directly when there's no condition or, if there's a condition, only when that condition is true.
To define a Condition is simple

```php

namespace \YourBundle\StateMachineProcess\Conditions\SomeCondition;

class SomeCondition extends \cosma\SimpleStateMachine\Abstract\Condition
{
    /**
    *   process that modifies the DataStructure in this state
    */
    protected process()
    {
        $this->getDataStructure->verifySomeConditions()
    }

    ....
}
```


### DOT Language ###

To take fully advantage of style attributes you need to know DOT language:

Links:
Drawing graphs with DOT - http://www.graphviz.org/Documentation/dotguide.pdf
Node Shapes - http://www.graphviz.org/doc/info/shapes.html


## License ##

Released under the MIT License, see LICENSE.