<?php

namespace App\Controller\Article;

use App\Controller\BaseController;
use App\Entity\Article;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class GetArticle extends BaseController
{
    #[Route('/api/articles/{article}', name: 'get_article', methods: ['GET'])]
    #[OA\Tag(name: 'Articles')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns an article',
        content: new OA\JsonContent(
            ref: new Model(type: Article::class, groups: ['read']),
        ),
    )]
    public function __invoke(Article $article): JsonResponse
    {
        return $this->json($article, Response::HTTP_OK, [], ['groups' => ['read']]);
    }
}
