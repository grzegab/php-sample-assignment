<?php

declare(strict_types=1);

namespace Statistics\Service\Factory;

use Statistics\Calculator\Factory\StatisticsCalculatorFactory;
use Statistics\Service\StatisticsService;

/**
 * Class StatisticsServiceFactory
 *
 * @package Statistics\Service\Factory
 */
class StatisticsServiceFactory
{

    /**
     * @return StatisticsService
     */
    public static function create(): StatisticsService
    {
        $calculatorFactory = new StatisticsCalculatorFactory();

        return new StatisticsService($calculatorFactory);
    }
}
