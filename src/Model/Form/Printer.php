<?php

namespace App\Model\Form;

use App\Model\Enum\PrinterTypes;
use Symfony\Component\Validator\Constraints as Assert;

class Printer
{
    /**
     * Printer name
     *
     * @var mixed
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(min = 2,max = 50)
     *
     */
    public $name;

    /**
     * Printer type.
     *
     * @var mixed
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Choice(
     *     callback="getTypes",
     *     message="invalid value"
     * )
     */
    public $type;

    public function __construct($name,$type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Get printer type
     *
     * @return string[]
     */
    public static function getTypes(): array
    {
        return PrinterTypes::getList();
    }
}
