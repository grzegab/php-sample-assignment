<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class NoopCalculator extends AbstractCalculator
{

    protected const UNITS = 'posts';

    /**
     * @var array
     */
    private array $authorsIds = [];

    /**
     * @var int
     */
    private int $postCount = 0;

    /**
     * @inheritDoc
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        if (! in_array($postTo->getAuthorId(), $this->authorsIds, true)) {
            $this->authorsIds[] = $postTo->getAuthorId();
        }

        $this->postCount++;
    }

    /**
     * @inheritDoc
     */
    protected function doCalculate(): StatisticsTo
    {
        $value = count($this->authorsIds) > 0 ? $this->postCount / count($this->authorsIds) : 0;

        return (new StatisticsTo())->setValue(round($value,2));
    }
}
