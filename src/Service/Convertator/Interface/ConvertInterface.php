<?php

namespace App\Service\Convertator\Interface;

/**
 * Interface ConvertInterface.
 * @package App\Service\Convertator
 */
interface ConvertInterface
{
    public function toPdf(string $pdfName);

    public function setData(string $data): static;
}