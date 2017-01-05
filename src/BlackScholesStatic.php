<?php

namespace shadiakiki1986;

// Based on http://cseweb.ucsd.edu/~goguen/courses/130/SayBlackScholes.html
// https://en.wikipedia.org/wiki/Black%E2%80%93Scholes_model#Black.E2.80.93Scholes_formula
class BlackScholesStatic {

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

  // call_put_flag: 'c' for call, or 'p' for put
  static public function calculate(string $call_put_flag, $S, $X, $T, $r, $v)  {
    // to avoid division by 0
    if($v==0) $v=0.0000000001;
    if($T==0) $T=0.0000000001;

    $d1 = ( log($S / $X) + ($r + pow($v, 2) / 2) * $T ) / ( $v * pow($T, 0.5) );
    $d2 = $d1 - $v * pow($T, 0.5);
    if ($call_put_flag == 'c') {
      return $S * self::cumnormdist($d1) - $X * exp( -$r * $T ) * self::cumnormdist($d2);
    }

    return $X * exp( -$r * $T ) * self::cumnormdist(-$d2) - $S * self::cumnormdist(-$d1);
  }

}

