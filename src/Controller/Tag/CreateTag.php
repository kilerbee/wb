<?php

namespace App\Controller\Tag;

use App\Controller\BaseController;
use App\Entity\Tag;
use App\Response\ErrorResponse;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

class CreateTag extends BaseController
{
    #[Route('/api/tags', name: 'create_tag', methods: ['POST'])]
    #[OA\Tag(name: 'Tags')]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: Tag::class, groups: ['write']),
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'Returns created tag',
        content: new OA\JsonContent(
            ref: new Model(type: Tag::class, groups: ['read']),
        ),
    )]
    #[ErrorResponse]
    public function __invoke(Request $request): JsonResponse
    {
        $tag = $this->serializer->deserialize(
            $request->getContent(),
            Tag::class,
            'json',
            (new ObjectNormalizerContextBuilder())
                ->withGroups(['write'])
                ->toArray(),
        );

        $errors = $this->validator->validate($tag);

        if ($errors->count() > 0) {
            return $this->respondValidationError($errors);
        }

        $this->entityManager->persist($tag);
        $this->entityManager->flush();

        return $this->json($tag, Response::HTTP_CREATED, [], ['groups' => ['read']]);
    }
}
