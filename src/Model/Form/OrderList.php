<?php

namespace App\Model\Form;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Form for order list request
 *
 * Class OrderList
 *
 * @package App\Model\Form
 */
class OrderList
{
    /**
     * Printer id
     *
     * @Assert\NotBlank()
     * @assert\Type(type="int")
     * @Assert\Positive
     */
    protected $printerId;

    /**
     * Limit
     *
     * @var int
     *
     * @Assert\Type(type ="int",
     *  message="{value} is an invalid format"
     * )
     * /**
     * @Assert\Range(
     *  min = 0,
     *  max = 100,
     * )
     * @Assert\PositiveOrZero
     */
    protected $limit;

    /**
     * Page
     *
     * @var int
     *
     * * @Assert\Type(type ="int",
     *  message="{value} is an invalid format"
     * )
     *
     * @Assert\Range(
     *  min = 0,
     *  max = 100,
     * )
     * @Assert\PositiveOrZero
     */
    protected $page;


    public function __construct($printerId,$page,$limit)
    {
        $this->printerId = (int)$printerId;
        $this->limit = empty($this->limit)
            ? 10
            : $limit;
        $this->page = empty($page) ? 1 : (int)$page;
    }

    /**
     * Get order detail in json format
     *
     * @return int
     */
    public function getPrinterId(): int
    {
        return $this->printerId;
    }

    /**
     * Get order detail in json format
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Get order amount
     *
     * @return ?int
     */
    public function getPage(): int
    {
        return $this->page;
    }
}
