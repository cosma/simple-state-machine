SimpleStateMachine -  A very simple State Machine  [![Build Status](https://drone.io/bitbucket.org/cosma/simple-state-machine/status.png)](https://drone.io/bitbucket.org/cosma/simple-state-machine/latest)
=================================================

- A Simple State Machine without persistence and timeouts.
- States can modify a Data object which will be injected in the initial State.
- The State Machine graph can be visualised in a UML diagram generated in different formats.


## Table of Contents
--------------------

- [Installation](#markdown-header-installation)
- [Usage](#markdown-header-usage)
- [Reference](#markdown-header-reference)
    - [Defining Data Object](#markdown-header-defining-data-object)
    - [Defining States](#markdown-header-defining-states)
    - [Define Conditions](#markdown-header-define-conditions)
    - [Graph Diagram](#markdown-header-graph-diagram)
    - [Export Formats](#markdown-header-export-formats)
    - [DOT Language](#markdown-header-dot-language)
- [Tests](#markdown-header-tests)
- [License](#markdown-header-license)




## Installation ##
------------------

Simple State Machine is installable via [Composer](https://getcomposer.org/)
as [cosma/simple-state-machine](https://packagist.org/packages/cosma/simple-state-machine).

```php
{
    "require": {
        "cosma/simple-state-machine": "1.0.*"
    }
}
```




## Usage ##
-----------

Let's follow the example of a simple price calculator state machine.

```php
namespace \MyProject;

/**
*   Simple State Machine
*/
$priceStateMachine = \Cosma\SimpleStateMachine\StateMachine('Price Calculator State Machine');


/**
*   Your Data object which can be modify by the State Machines
*   Has to implement the interface \Cosma\SimpleStateMachine\InterfaceData
*/
$price = new \YourProject\Price();

/**
*   Start State of the State Machine
*   Has to extends the abstract \Cosma\SimpleStateMachine\AbstractState
*/
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
---------------

### Defining Data Object ###

The Data object can be modify by the State Machines transitions and State.

The Data class must implement the interface \Cosma\SimpleStateMachine\InterfaceData.

InterfaceData is a empty interface but is used to force Type hinting.

```php
namespace \MyProject\PriceStateMachine;

class Price implements \Cosma\SimpleStateMachine\InterfaceData
{
    /**
    *   @var float
    */
    private $value;

    public function __constructor()
    {
        $this->value = $this->getPriceFromDB();
    }

    /**
    *    getters, setters and other functions
    */
    ...
}
```



### Defining States ###

All states must extend the class \Cosma\SimpleStateMachine\AbstractState

```php
namespace \MyProject\PriceStateMachine\States;

class AddVATState extends \Cosma\SimpleStateMachine\AbstractState
{
    /**
    *   Set the label for this State used in State Machine diagram
    */
    public function getLabel()
    {
        return 'Add VAT Tax';
    }

    /**
    *   Modify the Data object
    */
    protected function process()
    {
        $price = $this->getData();
        $price->setValue($price->getValue() * 1.19);
        ...
    }

    /**
    *   Configure the Transitions from this State to another States or itself in case of a loop
    *   You may set in what Condition that Transition takes place
    *   The order to check upon the validity of conditions and forward to next State is from up to down
    */
    protected function configureAvailableTransitions()
    {
        $this->addTransition(
                            '\YourProject\PriceStateMachine\States\AddDiscount',
                            '\YourProject\PriceStateMachine\Conditions\IfGreaterThan1000'
        );

        $this->addTransition('NewStateClass', 'ConditionClass');

        $this->addTransition('\YourProject\PriceStateMachine\States\AddDiscount');
        ...
    }
}
```


### Defining Conditions ###

A Transition between states is possible directly when there is no condition or,
if there is a condition, only when that condition is true.

All Conditions must extend \Cosma\SimpleStateMachine\AbstractCondition class

```php
namespace namespace \MyProject\PriceStateMachine\Conditions;

class SomeWildCondition extends \Cosma\SimpleStateMachine\AbstractCondition
{
    /**
    *   @return string
    */
    public function getLabel()
    {
        return "Some Wild Condition";
    }

    /**
    *   @return bool
    */
    public function isTrue()
    {
        $data = $this->getData();
        return $this->checkSomething($data);
    }
    ...
}
```



### Graph Diagram ###

You can easily visualise the State Machine Diagram

```php
namespace \MyProject;

/**
*   Generate the Diagram of the State Machine.
*   Choose the format
*/
$graphic = new Graphic('svg');
$diagramSVG = $priceStateMachine->draw($graphic);

echo $diagramSVG;
```



### Export Formats ###


The output is delivered in various formats.

The most used export formats are:

- [PNG](https://bitbucket.org/cosma/simple-state-machine/raw/master/tests/Cosma/SimpleStateMachine/Example/Draw/Formats/PNG.png)
- [PDF](https://bitbucket.org/cosma/simple-state-machine/raw/master/tests/Cosma/SimpleStateMachine/Example/Draw/Formats/PDF.pdf)
- [SVG](https://bitbucket.org/cosma/simple-state-machine/raw/master/tests/Cosma/SimpleStateMachine/Example/Draw/Formats/SVG.xml)
- [DOT](https://bitbucket.org/cosma/simple-state-machine/raw/master/tests/Cosma/SimpleStateMachine/Example/Draw/Formats/DOT.dot)
- [EPS](https://bitbucket.org/cosma/simple-state-machine/raw/master/tests/Cosma/SimpleStateMachine/Example/Draw/Formats/EPS.eps)
- [TIFF](https://bitbucket.org/cosma/simple-state-machine/raw/master/tests/Cosma/SimpleStateMachine/Example/Draw/Formats/TIFF.tiff)
- [JPG](https://bitbucket.org/cosma/simple-state-machine/raw/master/tests/Cosma/SimpleStateMachine/Example/Draw/Formats/JPG.jpg) (low quality)
- [GIF](https://bitbucket.org/cosma/simple-state-machine/raw/master/tests/Cosma/SimpleStateMachine/Example/Draw/Formats/GIF.gif) (low quality)
- [BMP](https://bitbucket.org/cosma/simple-state-machine/raw/master/tests/Cosma/SimpleStateMachine/Example/Draw/Formats/BMP.bmp) (low quality)

All supported formats are the DOT output formats: bmp, canon, cgimage, cmap, cmapx, cmapx_np, dot, eps, exr, fig, gif, gv, icns,
ico, imap, imap_np, ismap, jp2, jpe, jpeg, jpg, pct, pdf, pic, pict, plain, plain-ext, png, pov, ps, ps2, psd, sgi, svg, svgz,
tga, tif, tiff, tk, vml, vmlz, x11, xdot, xdot1.2, xdot1.4, xlib



### DOT Language ###

Stands for graph description language and you can read more [here](http://en.wikipedia.org/wiki/DOT_(graph_description_language))

To take fully advantage of style attributes you need to know DOT language.

When defining a Condition or a State, you can easily modify the protected $styleAttributes property
and overwrite the default style for a State or a Condition.

By this you can manipulate the color, font and shape of States and Conditions

```php
namespace \MyProject\PriceStateMachine\States;

class MyState extends \Cosma\SimpleStateMachine\AbstractState
{
    ...
    /**
    *   An array of DOT attributes to overwrite the default style of a State/Condition
    */
    protected $styleAttributes = array(
        'fillcolor' => '#A8CE9F',
        'style' => 'filled',
        'fontcolor' => '#000000',
        'fontsize' => 12,
        'penwidth' => 1,
    );
    ...
}
```

DOT Useful Links:

1. Drawing graphs with DOT - [download a pdf](http://www.graphviz.org/Documentation/dotguide.pdf)

2. Node Shapes - [shapes of a node](http://www.graphviz.org/doc/info/shapes.html)



## Tests ##
-----------

```bash
vendor/phpunit/phpunit/phpunit.php --coverage-text  --coverage-html=tests/coverage tests
```




## License ##
--------------
Released under the MIT License, see LICENSE.