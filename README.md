# php-blackscholes [![Build Status](https://travis-ci.org/shadiakiki1986/php-blackscholes.svg?branch=master)](https://travis-ci.org/shadiakiki1986/php-blackscholes)
Black-Scholes option pricing in php

Based on [Black-Scholes in Multiple Languages]( http://cseweb.ucsd.edu/~goguen/courses/130/SayBlackScholes.html) and [wikipedia formula](https://en.wikipedia.org/wiki/Black%E2%80%93Scholes_model#Black.E2.80.93Scholes_formula)

# Installation
`composer require shadiakiki1986/php-blackscholes`

# Usage

## Example
Call option price example from [quora](https://invento.quora.com/Advanced-Black-Scholes-calculation-with-a-real-example)
```php
require_once 'vendor/autoload.php';

$strike = 470;
$interest = 0.02;
$timeToMaturity = 0.17;
$underlyingPrice = 460;
$volatility = 0.58;
$bs = new \shadiakiki1986\BlackScholes::calculate(
  $underlyingPrice,
  $strike,
  $timeToMaturity,
  $interest, 
  $volatility
);
var_dump($bs->call());
```
will display `40.1047` (note that they have a mistake in their d1 function)


Alternatively
```php
$call = new \shadiakiki1986\BlackScholesStatic::calculate(
  'c',
  $underlyingPrice,
  $strike,
  $timeToMaturity,
  $interest, 
  $volatility
);
var_dump($call);
```

