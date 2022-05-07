<?php

namespace App\Service\HtmlGenerator\Interface;

/**
 * Interface HtmlGeneratorInterface
 *
 * @package App\Service\HtmlGenerator
 */
interface HtmlGeneratorInterface
{
    public function parseOrderToHtml(): string;
}