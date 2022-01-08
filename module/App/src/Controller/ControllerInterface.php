<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Interface ControllerInterface
 *
 * @package App\Controller
 */
interface ControllerInterface
{

    /**
     * @param array  $vars
     * @param string $template
     * @param bool   $useLayout
     */
    public function render(array $vars, string $template, bool $useLayout = true): void;
}
