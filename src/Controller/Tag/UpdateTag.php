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

final class UpdateTag extends BaseController
{
    #[Route('/api/tags/{tag}', name: 'update_tag', methods: ['POST'])]
    #[OA\Tag(name: 'Tags')]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: Tag::class, groups: ['write']),
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns updated tag',
        content: new OA\JsonContent(
            ref: new Model(type: Tag::class, groups: ['read']),
        ),
    )]
    #[ErrorResponse]
    public function __invoke(Request $request, Tag $tag): JsonResponse
    {
        $updatedTag = $this->serializer->deserialize(
            $request->getContent(),
            Tag::class,
            'json',
            (new ObjectNormalizerContextBuilder())
                ->withGroups(['write'])
                ->withObjectToPopulate($tag)
                ->toArray(),
        );

        $errors = $this->validator->validate($updatedTag);

        if ($errors->count() > 0) {
            return $this->respondValidationError($errors);
        }

        $this->entityManager->persist($updatedTag);
        $this->entityManager->flush();

        return $this->json($updatedTag, Response::HTTP_OK, [], ['groups' => ['read']]);
    }
}
