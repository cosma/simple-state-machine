SimpleStateMachine -  A very simple State Machine  [![Build Status](https://drone.io/bitbucket.org/cosma/simple-state-machine/status.png)](https://drone.io/bitbucket.org/cosma/simple-state-machine/latest)
=================================================

- A Simple State Machine without persistence and timeouts.
- States can be defined to modify the Data Structure object.
- The State Machine graph can be visualised in a UML diagram generated in different formats.



## Installation ##

This is installable via [Composer](https://getcomposer.org/) as [cosma/simple-state-machine](https://packagist.org/packages/cosma/simple-state-machine).

## Table of Contents

- [Usage](#usage)
- [Reference](#reference)
    - [Defining States](#defining-states)
    - [Configure Transitions](#configure-transitions)
    - [Define Conditions](#define-conditions)
    - [DOT Language](#dot-language)
- [Tests](#tests)  
- [License](#license)  

## Usage ##

To use State Machine is very simple.

Let's follow the simple example of a simple price calculator state machine.

```php
//   Simple State Machine
$priceStateMachine = \Cosma\SimpleStateMachine\StateMachine('Price Calculator State Machine');


//   Your Data object which can be modify by the State Machines
//   Has to implement the interface \Cosma\SimpleStateMachine\InterfaceData

$price = new \YourProject\Price();

//  Start State of the State Machine
//   Has to extends the abstract \Cosma\SimpleStateMachine\AbstractState

$initialPriceState = \YourProject\PriceStateMachine\States\InitialPrice($price);

/**
*   Simple State Machine cannot run without setting the start State
*/
$priceStateMachine->setState($initialPriceState);

/**
*   Running the State Machine
*   During this process the Data object will be modified depending on teh configuration of the Machine
*/
$priceStateMachine->run();

/**
*   Retrieve the Data object at the end of the process
*/
$finalPrice = $priceStateMachine->getState()->getData();


/**
*   Generate the Diagram of the State Machine.
*   Choose the format
*/
$graphic = new Graphic('svg');
$diagramSVG = $priceStateMachine->draw($graphic);
echo $diagramSVG;
```

## Reference ##

### Defining States ###

Example of a state

```php
namespace \YourBundle\StateMachineProcess\States\SomeState;

class SomeState extends \Cosma\SimpleStateMachine\Abstract\State
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

class SomeState extends \Cosma\SimpleStateMachine\Abstract\State
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

class SomeCondition extends \Cosma\SimpleStateMachine\Abstract\Condition
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

## Tests ##

vendor/phpunit/phpunit/phpunit.php -c phpunit.xml.dist  --coverage-html tests/coverage tests

## License ##

Released under the MIT License, see LICENSE.