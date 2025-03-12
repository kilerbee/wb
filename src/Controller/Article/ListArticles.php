<?php

namespace App\Controller\Article;

use App\Controller\BaseController;
use App\Entity\Article;
use App\Service\ArticleService;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

final class ListArticles extends BaseController
{
    #[Route('/api/articles', name: 'list_articles', methods: ['GET'])]
    #[OA\Tag(name: 'Articles')]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns list of all tags',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'articles',
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: Article::class, groups: ['read'])),
                ),
            ],
        ),
    )]
    public function __invoke(Request $request, ArticleService $articleService): JsonResponse
    {
        $tagsFilter = $request->query->all('tags');

        $articles = $articleService->processArticleQuery($tagsFilter);

        return $this->json(['articles' => $articles], Response::HTTP_OK, [], ['groups' => ['read']]);
    }
}
