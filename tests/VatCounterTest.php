<?php

namespace tests;

include '../VatCounter.php';

class VatCounterTest extends \PHPUnit_Framework_TestCase
{
    protected $vatCounter;

    public function setUp()
    {
        $this->vatCounter = new \VatCounter();
    }

    /**
     * @dataProvider dataProviderForTestCountTax
     * @param float $netAmount
     * @param int $vatPercent
     * @param float $expectedResult
     */
    public function testCountTax($netAmount, $vatPercent, $expectedResult)
    {
        $result = $this->vatCounter->countTax($netAmount, $vatPercent);

        $this->assertEquals($expectedResult, $result, '', 0.001);
    }

    public function dataProviderForTestCountTax()
    {
        return [
            'Case 1 Big number' => [20499.95, 23, 4714.99],
            'Case 2 Check round-up' => [0.10, 23, 0.03],
            'Case 3' => [100.00, 3, 3.00],
            'Case 4' => [0.99, 50, 0.50],
            'Case 5' => ['1.00', '1', 0.01]
        ];
    }

    public function testInvalidAmount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The amount cannot be less than zero');

        $this->vatCounter->countTax(-39.0, 1);
    }

    public function testInvalidPercent()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The vat percent must be in 0-100 range');

        $this->vatCounter->countTax(5.00, -5);
    }

    public function testPercentTooLarge()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The vat percent must be in 0-100 range');

        $this->vatCounter->countTax(5.00, 101);
    }
}
