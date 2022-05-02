<?php

namespace App\Model\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Form for order request
 *
 * Class Order
 *
 * @package App\Model\Form
 */
class Order
{
    /**
     * OrderInfo
     *
     * @Assert\NotBlank
     * @Assert\Json(
     *     message = "{value} is an invalid Json."
     * )
     *
     */
    protected $info;

    /**
     * Printer id
     *
     * @Assert\NotBlank()
     * @assert\Type(type="int")
     * @Assert\Positive
     *
     */
    protected $printerId;

    /**
     * Order total amount
     *
     * @Assert\NotBlank()
     * @assert\Type(type="int")
     *
     */
    protected $amount;

    /**
     * Order constructor.
     *
     * @param $printerId
     * @param $info
     * @param $amount
     */
    public function __construct($printerId, $info, $amount)
    {
        $this->info = $info;
        $this->amount = (int)$amount;
        $this->printerId = (int)$printerId;
    }

    /**
     * Get order datail in json format
     *
     * @return string
     */
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * Get order amount
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Get order printer id
     *
     * @return int
     */
    public function getPrinterId(): int
    {
        return $this->printerId;
    }

    /**
     * Validate correct format order detail
     *
     * @param ExecutionContextInterface $context
     * @param $payload
     *
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        $infoDetail = json_decode($this->info, true);
        if (count($infoDetail) == 0) {
            $context->buildViolation('Empty order detail info')
                ->atPath('info')
                ->addViolation();
        }
        foreach ($infoDetail as $info) {
            if (
                !(isset($info["name"])) ||
                !(isset($info["count"])) ||
                !(isset($info["price"]))) {
                $context->buildViolation('Invalid info format')
                    ->atPath('info')
                    ->addViolation();
            }
        }
    }
}
