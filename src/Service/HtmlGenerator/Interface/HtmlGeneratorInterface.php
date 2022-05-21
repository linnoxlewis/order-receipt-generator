<?php

namespace App\Service\HtmlGenerator\Interface;

use App\Model\Entity\Order;

/**
 * Interface HtmlGeneratorInterface
 *
 * @package App\Service\HtmlGenerator
 */
interface HtmlGeneratorInterface
{
    public function parseOrderToHtml(): string;

    public function setOrder(Order $order): static;
}