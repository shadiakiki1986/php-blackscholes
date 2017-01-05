<?php

namespace shadiakiki1986;

// http://cseweb.ucsd.edu/~goguen/courses/130/SayBlackScholes.html
// https://en.wikipedia.org/wiki/Black%E2%80%93Scholes_model#Black.E2.80.93Scholes_formula
class BlackScholes {

  function __construct(
    float $underlyingPrice,
    float $strike,
    float $timeToMaturity,
    float $interest,
    float $volatility
  ) {
#    if($volatility==0) $volatility = 0.0000001;
#    if($timeToMaturity==0) $timeToMaturity = 0.000001;
#    if($strike==0) $strike = 0.000001;

    $this->underlyingPrice=$underlyingPrice;
    $this->strike=$strike;
    $this->timeToMaturity=$timeToMaturity;
    $this->interest=$interest;
    $this->volatility=$volatility;
  }

  public function d1() {
    if($this->volatility==0 || $this->timeToMaturity==0 || $this->strike==0) return -INF;

    $prefix = 1/$this->volatility/sqrt($this->timeToMaturity);
    $suffix1 = log($this->underlyingPrice/$this->strike);
    $suffix2=($this->interest+pow($this->volatility,2)/2)*$this->timeToMaturity;
    return $prefix*($suffix1+$suffix2);
  }

  public function d2() {
    return $this->d1()-$this->volatility*sqrt($this->timeToMaturity);
  }

  static public function cumnormdist($x) {
    $Pi = 3.141592653589793238;
    $a1 = 0.319381530;
    $a2 = -0.356563782;
    $a3 = 1.781477937;
    $a4 = -1.821255978;
    $a5 = 1.330274429;
    $L = abs($x);
    $k = 1 / ( 1 + 0.2316419 * $L);
    $p = 1 - 1 /  pow(2 * $Pi, 0.5) * exp( -pow($L, 2) / 2 ) * ($a1 * $k + $a2 * pow($k, 2)
       + $a3 * pow($k, 3) + $a4 * pow($k, 4) + $a5 * pow($k, 5) );
    if ($x >= 0) { 
      return $p;
    } else {
      return 1-$p;
    }
  }


  public function Nd1() {
    return self::cumnormdist($this->d1());
  }

  public function Nd2() {
    return self::cumnormdist($this->d2());
  }

  public function call() {
    return $this->Nd1()*$this->underlyingPrice - $this->Nd2()*$this->strike*exp(-1*$this->interest*$this->timeToMaturity);
  }

}

