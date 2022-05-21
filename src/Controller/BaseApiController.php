<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base api controller
 *
 */
class BaseApiController extends AbstractController
{
    /**
     * Validation input params.
     *
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * Constructor
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validate form input params
     *
     * @param mixed $form form Model
     *
     * @return void
     * @throws BadRequestException
     */
    protected function validate(mixed $form): void
    {
        $errors = $this->validator->validate($form);
        if ($errors->count() > 0) {
            throw new BadRequestException($errors);
        }
    }
}