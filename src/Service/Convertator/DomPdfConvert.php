<?php

namespace App\Service\Convertator;

use Dompdf\Dompdf;
use Psr\Log\LoggerInterface;

/**
 * Convert class to pdf
 *
 * Class Convert
 *
 * @package App\Service\Convertator
 */
class DomPdfConvert extends Convert
{
    /**
     * Base convert server.
     *
     * @var Dompdf
     */
    protected Dompdf $htmlPdfService;

    /**
     * Convert constructor.
     */
    public function __construct(string          $webDir,
                                LoggerInterface $logger)
    {
        $this->htmlPdfService = new Dompdf();
        parent::__construct($webDir, $logger);
    }

    /**
     * Create pdf
     *
     * @return string
     */
    function createPdf(): string
    {
        $this->htmlPdfService->loadHtml($this->data);
        $this->htmlPdfService->setPaper('A4', 'landscape');
        $this->htmlPdfService->render();

        return $this->htmlPdfService->output();
    }
}
