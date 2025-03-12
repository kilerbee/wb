<?php

namespace App\Controller\Article;

use App\Controller\BaseController;
use App\DTO\ArticleRequest;
use App\Entity\Article;
use App\Response\ErrorResponse;
use App\Service\ArticleService;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

final class CreateArticle extends BaseController
{
    #[Route('/api/articles', name: 'create_article', methods: ['POST'])]
    #[OA\Tag(name: 'Articles')]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: ArticleRequest::class),
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'Returns created article',
        content: new OA\JsonContent(
            ref: new Model(type: Article::class, groups: ['read']),
        ),
    )]
    #[ErrorResponse]
    public function __invoke(Request $request, ArticleService $articleService): JsonResponse
    {
        /** @var ArticleRequest $requestArticle */
        $requestArticle = $this->serializer->deserialize(
            $request->getContent(),
            ArticleRequest::class,
            'json',
        );

        $errors = $this->validator->validate($requestArticle);

        if ($errors->count() > 0) {
            return $this->respondValidationError($errors);
        }

        $article = $articleService->processArticleRequest($requestArticle);

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return $this->json($article, Response::HTTP_CREATED, [], ['groups' => ['read']]);
    }
}
