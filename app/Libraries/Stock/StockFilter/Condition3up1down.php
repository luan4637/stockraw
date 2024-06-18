<?php

namespace App\Libraries\Stock\StockFilter;

class Condition3up1down implements ParamInterface
{
    /**
     * @inheritdoc
     */
    public function getValid(array $stocks)
    {
        $results = [];
        foreach ($stocks as $stock) {
            if ($stock->cur > 0) {
                if ($stock->cur <= $stock->cur1Ago
                    && $stock->cur1Ago >= $stock->cur2Ago
                    && $stock->cur2Ago >= $stock->cur3Ago
                    && $stock->cur3Ago >= $stock->cur4Ago) {
                        $results[] = $stock;
                    }
            } else {
                if ($stock->cur1Ago <= $stock->cur2Ago
                    && $stock->cur2Ago >= $stock->cur3Ago
                    && $stock->cur3Ago >= $stock->cur4Ago
                    && $stock->cur4Ago >= $stock->cur5Ago) {
                        $results[] = $stock;
                    }
            }
        }

        return $results;
    }
}
