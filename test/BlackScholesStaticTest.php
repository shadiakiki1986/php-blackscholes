<?php

namespace shadiakiki1986;

class BlackScholesStaticTest extends \PHPUnit_Framework_TestCase
{
    // test against values from table: http://wps.aw.com/wps/media/objects/3853/3945845/ch15/table1.html
    public function testCumnorm() {
      // edge cases
      $this->assertEquals(0.0019,round(BlackScholesStatic::cumnormdist(-2.90),4));
      $this->assertEquals(0.9987,round(BlackScholesStatic::cumnormdist(3.0),4));

      // colored cases in table
      $this->assertEquals(0.7157,round(BlackScholesStatic::cumnormdist(0.57),4));
      $this->assertEquals(0.7673,round(BlackScholesStatic::cumnormdist(0.73),4));
    }

/*    public function testInfinity() {
      $bs = new BlackScholes(1, 1, 1, 1, 1);
      $bs->volatility=0;
      $this->assertEquals(1,$bs->Nd1());
    }
*/
    public function testCallNotNegative()
    {
      $strike = 470;
      $interest = 0;
      $timeToMaturity = 0;
      $underlyingPrice = 460;
      $volatility = 0;
      $bs = BlackScholesStatic::calculate(
        'c',
        $underlyingPrice,
        $strike,
        $timeToMaturity,
        $interest, 
        $volatility
      );

#      $this->assertEquals(INF,$bs->d1());
#      $this->assertEquals(1,$bs->Nd1());
#      $this->assertEquals(INF,$bs->d2());
#      $this->assertEquals(1,$bs->Nd2());

      $this->assertLessThan(2,1);
      $this->assertEquals(0,$bs);
    }

    // Call option price from [here](https://invento.quora.com/Advanced-Black-Scholes-calculation-with-a-real-example)
    // Quora have a mistake in their d1 formula: time to maturity needs to be divided, not multiplied, or at least use parentheses
    public function testExampleQuora()
    {
      $strike = 470;
      $interest = 2/100;
      $timeToMaturity = 0.17;
      $underlyingPrice = 460;
      $volatility = 0.58;
      $bs = BlackScholesStatic::calculate(
        'c',
        $underlyingPrice,
        $strike,
        $timeToMaturity,
        $interest, 
        $volatility
      );

      // they wrongly have 37 .. should be 40
      // $this->assertEquals(37,$bs);
      $this->assertEquals(40.1047,round($bs,4));
#      $this->assertEquals(0.1875,$bs->d1());

      $volatility = 0.25;
      $bs = BlackScholesStatic::calculate(
        'c',
        $underlyingPrice,
        $strike,
        $timeToMaturity,
        $interest, 
        $volatility
      );
#      $this->assertEquals(0.9252,round($bs->Nd1(),4));
#      $this->assertEquals(0.9095,round($bs->Nd2(),4));
      // they wrongly have 16.67
      //$this->assertEquals(16.67,$bs);
      $this->assertEquals(15.1714,round($bs,4));
    }

    // https://www.easycalculation.com/statistics/learn-black-sholes.php
    // These guys have a negative option price! lol
    // and their d1 is also wrong, same mistake as Quora
    public function testExampleEasycalculation()
    {
      $strike = 205;
      $interest = 0.2175/100;
      $timeToMaturity = 4/365;
      $underlyingPrice = 210.59;
      $volatility = 14.04/100;
      $bs = BlackScholesStatic::calculate(
        'c',
        $underlyingPrice,
        $strike,
        $timeToMaturity,
        $interest, 
        $volatility
      );

      #$this->assertEquals(1.8394,$bs->d1());
      // they wrongly have -8.13
      // $this->assertEquals(-8.1313,$bs);
      $this->assertEquals(5.6351,round($bs,4));
    }
}
