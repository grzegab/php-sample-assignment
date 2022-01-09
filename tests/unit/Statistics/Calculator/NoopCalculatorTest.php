<?php

namespace Tests\unit\Statistics\Calculator;

use PHPUnit\Framework\TestCase;
use SocialPost\Dto\SocialPostTo;
use Statistics\Calculator\NoopCalculator;
use Statistics\Dto\ParamsTo;
use stdClass;

use function PHPUnit\Framework\once;

class NoopCalculatorTest extends TestCase
{
    public function testDoCalculateEmpty()
    {
        $noopCalculator = new NoopCalculator();

        $paramsTo = $this->createMock(ParamsTo::class);
        $paramsTo->method('getStatName')->willReturn('noop');
        $noopCalculator->setParameters($paramsTo);

        $this->assertSame('noop', $noopCalculator->calculate()->getName());
        $this->assertSame(0.0, $noopCalculator->calculate()->getValue());
        $this->assertSame('posts', $noopCalculator->calculate()->getUnits());
        $this->assertSame([], $noopCalculator->calculate()->getChildren());
    }

    public function testDoCalculateAccumulate()
    {
        $noopCalculator = new NoopCalculator();

        $paramsTo = $this->createMock(ParamsTo::class);
        $paramsTo->method('getStatName')->willReturn('noop');
        $noopCalculator->setParameters($paramsTo);

        $this->assertSame('noop', $noopCalculator->calculate()->getName());
        $this->assertSame([], $noopCalculator->calculate()->getChildren());
        $this->assertSame('posts', $noopCalculator->calculate()->getUnits());

        //accumulate data
        $post1 = $this->createMock(SocialPostTo::class);
        $post1->method('getAuthorId')->willReturn("1");
        $noopCalculator->accumulateData($post1);
        $this->assertSame(1.0, $noopCalculator->calculate()->getValue());

        $post2 = $this->createMock(SocialPostTo::class);
        $post2->method('getAuthorId')->willReturn("1");
        $noopCalculator->accumulateData($post2);
        $this->assertSame(2.0, $noopCalculator->calculate()->getValue());

        $post3 = $this->createMock(SocialPostTo::class);
        $post3->method('getAuthorId')->willReturn("2");
        $noopCalculator->accumulateData($post3);
        $this->assertSame(1.5, $noopCalculator->calculate()->getValue());
    }

    public function testDoCalculateNullAuthor()
    {
        $noopCalculator = new NoopCalculator();

        $paramsTo = $this->createMock(ParamsTo::class);
        $paramsTo->method('getStatName')->willReturn('noop');
        $noopCalculator->setParameters($paramsTo);

        $this->assertSame('noop', $noopCalculator->calculate()->getName());
        $this->assertSame([], $noopCalculator->calculate()->getChildren());
        $this->assertSame('posts', $noopCalculator->calculate()->getUnits());

        //accumulate data
        $post1 = $this->createMock(SocialPostTo::class);
        $post1->method('getAuthorId')->willReturn(null);
        $noopCalculator->accumulateData($post1);
        $this->assertSame(1.0, $noopCalculator->calculate()->getValue());

        $post2 = $this->createMock(SocialPostTo::class);
        $post2->method('getAuthorId')->willReturn(null);
        $noopCalculator->accumulateData($post2);
        $this->assertSame(2.0, $noopCalculator->calculate()->getValue());

        $post3 = $this->createMock(SocialPostTo::class);
        $post3->method('getAuthorId')->willReturn("2");
        $noopCalculator->accumulateData($post3);
        $this->assertSame(1.5, $noopCalculator->calculate()->getValue());
    }
}
