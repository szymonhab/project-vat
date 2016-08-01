<?php

/**
 * Class VatCounter - helper for VAT tax counting
 *
 * It uses integer to handle currency, when we use 64 bit PHP version it should be enough for average web application.
 * For larger system, we can use money amount class with various getters/setters which will store currency as integer,
 * and print it in various formats.
 *
 * @author Szymon Habela <szymonhab@gmail.com>
 */
class VatCounter
{
    /**
     * @param int $netAmount Net amount in for example: cent, penny or grosze
     * @param int $vatPercent Percent of VAT tax
     *
     * @returns int $tax Tax amount in for example: cent, penny or grosze
     * @throws Exception
     */
    public function countTax($netAmount, $vatPercent)
    {
        $netAmount = (int) $netAmount;
        $vatPercent = (int) $vatPercent;

        if ($netAmount < 0) {
            throw new \InvalidArgumentException('The amount cannot be less than zero');
        } else if ($vatPercent < 0 || $vatPercent > 100) {
            throw new \InvalidArgumentException('The vat percent must be in 0-100 range');
        }

        $percentMultiplier = $vatPercent/100;
        $tax = round($netAmount*$percentMultiplier, 0);

        return (int) $tax;
    }
}