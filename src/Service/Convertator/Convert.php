<?php

namespace App\Service\Convertator;

use App\Service\Convertator\Interface\ConvertInterface;
use Psr\Log\LoggerInterface;

/**
 * Convert class to pdf
 *
 * Class Convert
 *
 * @package App\Service\Convertator
 */
abstract class Convert implements ConvertInterface
{
    /**
     * data to pdf.
     *
     * @var string
     */
    protected string $data;

    /**
     * @var string
     */
    protected string $webDir;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Convert constructor.
     */
    public function __construct(string $webDir, LoggerInterface $logger)
    {
        $this->webDir = $webDir;
        $this->logger = $logger;
    }

    /**
     * Set data.
     *
     * @param string $data
     *
     * @return Convert
     */
    public function setData(string $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data.
     *
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * Generate pdf from data.
     *
     * @param string $pdfName file name
     *
     * @return bool
     */
    public function toPdf(string $pdfName): bool
    {
        try {
            $pdfFile = $this->createPdf();
            file_put_contents($this->webDir . '/' . $pdfName . '.pdf', $pdfFile);

            return true;
        } catch (\Throwable $ex) {
            $this->logger->error($ex->getMessage());

            return false;
        }
    }

    /**
     * Create pdf.
     *
     * @return string
     */
    abstract function createPdf(): string;
}
