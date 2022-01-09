<?php

declare(strict_types=1);

namespace Statistics\Dto;

/**
 * Interface StatisticsTo
 *
 * @package Statistics\Dto
 */
class StatisticsTo
{

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var float|null
     */
    private ?float $value;

    /**
     * @var string|null
     */
    private ?string $splitPeriod;

    /**
     * @var string|null
     */
    private ?string $units;

    /**
     * @var StatisticsTo[]
     */
    private array $children = [];

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value ?? null;
    }

    /**
     * @return StatisticsTo[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param StatisticsTo $child
     *
     * @return $this
     */
    public function addChild(StatisticsTo $child): self
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSplitPeriod(): ?string
    {
        return $this->splitPeriod ?? null;
    }

    /**
     * @param string $splitPeriod
     *
     * @return $this
     */
    public function setSplitPeriod(string $splitPeriod): self
    {
        $this->splitPeriod = $splitPeriod;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUnits(): ?string
    {
        return $this->units ?? null;
    }

    /**
     * @param string|null $units
     *
     * @return $this
     */
    public function setUnits(?string $units): self
    {
        $this->units = $units;

        return $this;
    }
}