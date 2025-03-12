<?php

namespace App\Controller\Tag;

use App\Controller\BaseController;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

final class ListTags extends BaseController
{
    #[Route('/api/tags', name: 'list_tags', methods: ['GET'])]
    #[OA\Tag(name: 'Tags')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns list of all tags',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'tags',
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Tag::class, groups: ['read'])),
                ),
            ],
        ),
    )]
    public function __invoke(TagRepository $repository): JsonResponse
    {
        return $this->json(['tags' => $repository->findAll()], Response::HTTP_OK, [], ['groups' => ['read']]);
    }
}
