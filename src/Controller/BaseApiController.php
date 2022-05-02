<?php

namespace App\Controller;

use App\Manager\Exception\ManagerException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseApiController extends AbstractController
{
    protected ValidatorInterface $validator;

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
     * @throws BadRequestException|ManagerException
     */
    protected function validate(mixed $form): void
    {
        $errors = $this->validator->validate($form);
        if ($errors->count() > 0) {
            throw new ManagerException($errors);
        }
    }
}