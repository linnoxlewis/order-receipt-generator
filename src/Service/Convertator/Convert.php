<?php

namespace App\Service\Convertator;

use App\Service\Convertator\Interface\ConvertInterface;
use Dompdf\Dompdf;
use Psr\Log\LoggerInterface;

/**
 * Convert class to pdf
 *
 * Class Convert
 *
 * @package App\Service\Convertator
 */
class Convert implements ConvertInterface
{
    /**
     * Base convert server.
     *
     * @var Dompdf
     */
    protected Dompdf $htmlPdfService;

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

    protected LoggerInterface $logger;

    /**
     * Convert constructor.
     */
    public function __construct(string $webDir,
                                Dompdf $htmlPdfService,
                                LoggerInterface $logger)
    {
        $this->htmlPdfService = $htmlPdfService;
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
            $this->htmlPdfService->loadHtml($this->data);
            $this->htmlPdfService->setPaper('A4', 'landscape');
            $this->htmlPdfService->render();

            $pdfFile = $this->htmlPdfService->output();
            file_put_contents($this->webDir . '/' . $pdfName . '.pdf', $pdfFile);

            return true;
        } catch (\Throwable $ex) {
            $this->logger->error($ex->getMessage());

            return false;
        }
    }
}
