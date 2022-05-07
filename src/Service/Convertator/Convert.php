<?php

namespace App\Service\Convertator;

use Spipu\Html2Pdf\Html2Pdf;

/**
 * Convert class to pdf
 *
 * Class Convert
 *
 * @package App\Service\Convertator
 */
class Convert
{
    /**
     * Base convert server.
     *
     * @var Html2Pdf
     */
    protected Html2Pdf $htmlPdfService;

    /**
     * data to pdf.
     *
     * @var string
     */
    protected string $data;

    /**
     * Convert constructor.
     */
    public function __construct()
    {
        $this->htmlPdfService = new Html2Pdf();

    }

    /**
     * Set data.
     *
     * @param string $data
     *
     * @return Convert
     */
    public function setData(string $data) :static
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
    public function toPdf(string $pdfName) : bool
    {
        try {
            $this->htmlPdfService->writeHTML($this->data);
            $this->htmlPdfService->output($pdfName . '.pdf','D');

            return true;
        } catch (\Throwable $ex) {
            var_dump($ex->getMessage());

            return false;
        }
    }
}
