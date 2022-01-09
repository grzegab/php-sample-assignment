<?php

namespace Tests\unit\Statistics\Calculator;

use PHPUnit\Framework\TestCase;
use SocialPost\Dto\SocialPostTo;
use Statistics\Calculator\MaxPostLength;
use Statistics\Dto\ParamsTo;

class MaxPostLengthTest extends TestCase
{
    public function testAccumulateEmpty()
    {
        $maxPostLengthCalculator = new MaxPostLength();

        $paramsTo = $this->createMock(ParamsTo::class);
        $paramsTo->method('getStatName')->willReturn('max');
        $maxPostLengthCalculator->setParameters($paramsTo);

        $this->assertSame('max', $maxPostLengthCalculator->calculate()->getName());
        $this->assertSame(0.0, $maxPostLengthCalculator->calculate()->getValue());
        $this->assertSame('characters', $maxPostLengthCalculator->calculate()->getUnits());
        $this->assertSame([], $maxPostLengthCalculator->calculate()->getChildren());
    }

    public function testAccumulateMax()
    {
        $maxPostLengthCalculator = new MaxPostLength();

        $paramsTo = $this->createMock(ParamsTo::class);
        $paramsTo->method('getStatName')->willReturn('max');
        $maxPostLengthCalculator->setParameters($paramsTo);

        $this->assertSame('max', $maxPostLengthCalculator->calculate()->getName());
        $this->assertSame('characters', $maxPostLengthCalculator->calculate()->getUnits());
        $this->assertSame([], $maxPostLengthCalculator->calculate()->getChildren());

        $post1 = $this->createMock(SocialPostTo::class);
        $post1->method('getText')->willReturn("abc");
        $maxPostLengthCalculator->accumulateData($post1);
        $this->assertSame(3.0, $maxPostLengthCalculator->calculate()->getValue());

        $post2 = $this->createMock(SocialPostTo::class);
        $post2->method('getText')->willReturn("a");
        $maxPostLengthCalculator->accumulateData($post2);
        $this->assertSame(3.0, $maxPostLengthCalculator->calculate()->getValue());

        $post3 = $this->createMock(SocialPostTo::class);
        $post3->method('getText')->willReturn("abc abc");
        $maxPostLengthCalculator->accumulateData($post3);
        $this->assertSame(7.0, $maxPostLengthCalculator->calculate()->getValue());

        $post4 = $this->createMock(SocialPostTo::class);
        $post4->method('getText')->willReturn("abc1abc12");
        $maxPostLengthCalculator->accumulateData($post4);
        $this->assertSame(9.0, $maxPostLengthCalculator->calculate()->getValue());
    }

    public function testAccumulateRandom()
    {
        $maxPostLengthCalculator = new MaxPostLength();

        $paramsTo = $this->createMock(ParamsTo::class);
        $paramsTo->method('getStatName')->willReturn('max');
        $maxPostLengthCalculator->setParameters($paramsTo);

        $this->assertSame('max', $maxPostLengthCalculator->calculate()->getName());
        $this->assertSame('characters', $maxPostLengthCalculator->calculate()->getUnits());
        $this->assertSame([], $maxPostLengthCalculator->calculate()->getChildren());

        $post1 = $this->createMock(SocialPostTo::class);
        $post1->method('getText')->willReturn(random_bytes(500));
        $maxPostLengthCalculator->accumulateData($post1);
        $this->assertSame(500.0, $maxPostLengthCalculator->calculate()->getValue());

        $post2 = $this->createMock(SocialPostTo::class);
        $post2->method('getText')->willReturn(random_bytes(5000));
        $maxPostLengthCalculator->accumulateData($post2);
        $this->assertSame(5000.0, $maxPostLengthCalculator->calculate()->getValue());
    }

    public function testAccumulateBigNumbers()
    {
        $maxPostLengthCalculator = new MaxPostLength();

        $paramsTo = $this->createMock(ParamsTo::class);
        $paramsTo->method('getStatName')->willReturn('max');
        $maxPostLengthCalculator->setParameters($paramsTo);

        $this->assertSame('max', $maxPostLengthCalculator->calculate()->getName());
        $this->assertSame('characters', $maxPostLengthCalculator->calculate()->getUnits());
        $this->assertSame([], $maxPostLengthCalculator->calculate()->getChildren());

        $post1 = $this->createMock(SocialPostTo::class);
        $post1->method('getText')->willReturn(random_bytes(500000));
        $maxPostLengthCalculator->accumulateData($post1);
        $this->assertSame(500000.0, $maxPostLengthCalculator->calculate()->getValue());

        $post2 = $this->createMock(SocialPostTo::class);
        $post2->method('getText')->willReturn(random_bytes(114217700));
        $maxPostLengthCalculator->accumulateData($post2);
        $this->assertSame(114217700.0, $maxPostLengthCalculator->calculate()->getValue());
    }
}
