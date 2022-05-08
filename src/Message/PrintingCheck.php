<?php
namespace App\Message;

use App\Model\Entity\Check;

class PrintingCheck
{
    private string $checkId;

    public function __construct(string $checkId)
    {
        $this->checkId = $checkId;
    }

    public function getCheckId(): string {
        return $this->checkId;
    }
}
