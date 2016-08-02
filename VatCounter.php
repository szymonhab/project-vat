<?php

/**
 * Class VatCounter - helper for VAT tax counting
 *
 * It uses float to handle currency.
 * For larger system, we can use money amount class or some of ready solutions with various getters/setters which will
 * store currency as decimal.
 *
 * @author Szymon Habela <szymonhab@gmail.com>
 */
class VatCounter
{
    /**
     * countTax According to business logic, we perform round-up to second digit after tax calculations.
     *
     * @param float $netAmount Net amount
     * @param int $vatPercent Percent of VAT tax
     *
     * @returns float $tax Tax amount
     * @throws Exception
     */
    public function countTax($netAmount, $vatPercent)
    {
        $netAmount = round((float) $netAmount, 2);
        $vatPercent = (int) $vatPercent;

        if ($netAmount < 0) {
            throw new \InvalidArgumentException('The amount cannot be less than zero');
        } else if ($vatPercent < 0 || $vatPercent > 100) {
            throw new \InvalidArgumentException('The vat percent must be in 0-100 range');
        }

        // easiest solution - do not divide vatPercent into 100 - then we can use ceil to round-up - because PHP does not have function which round-up to specified digit
        $tax = ceil($netAmount*$vatPercent);

        return ($tax/100);
    }
}