<?php
namespace App\Message;

/**
 * Printing check from order.
 */
class PrintingCheck
{
    /**
     * Check id.
     *
     * @var string
     */
    private string $checkId;

    /**
     * Message constructor.
     *
     * @param string $checkId
     */
    public function __construct(string $checkId)
    {
        $this->checkId = $checkId;
    }

    /**
     * Get check id.
     *
     * @return string
     */
    public function getCheckId(): string {
        return $this->checkId;
    }
}
