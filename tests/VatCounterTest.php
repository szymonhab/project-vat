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
     * @param int $netAmount
     * @param int $vatPercent
     * @param int $expectedResult
     */
    public function testCountTax($netAmount, $vatPercent, $expectedResult)
    {
        $result = $this->vatCounter->countTax($netAmount, $vatPercent);

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestCountTax()
    {
        return [
            'Case 1' => [2049995, 23, 471499],
            'Case 2' => [10, 23, 2],
            'Case 3' => [10000, 3, 300],
            'Case 4' => [99, 50, 50],
            'Case 5' => ['100', '1', 1]
        ];
    }

    public function testInvalidAmount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The amount cannot be less than zero');

        $this->vatCounter->countTax(-39, 1);
    }

    public function testInvalidPercent()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The vat percent must be in 0-100 range');

        $this->vatCounter->countTax(500, -5);
    }

    public function testPercentTooLarge()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The vat percent must be in 0-100 range');

        $this->vatCounter->countTax(500, 101);
    }
}
