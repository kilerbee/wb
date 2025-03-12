<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController extends AbstractController
{
    public function __construct(
        protected readonly SerializerInterface $serializer,
        protected readonly ValidatorInterface $validator,
        protected readonly EntityManagerInterface $entityManager,
    ) {
    }

    protected function respondValidationError(ConstraintViolationListInterface $errors): JsonResponse
    {
        return $this->json(
            data: $errors,
            status: Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }
}
