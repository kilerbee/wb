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
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;

final class UpdateArticle extends BaseController
{
    #[Route('/api/articles/{article}', name: 'update_article', methods: ['POST'])]
    #[OA\Tag(name: 'Articles')]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: ArticleRequest::class),
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns updated article',
        content: new OA\JsonContent(
            ref: new Model(type: Article::class, groups: ['read']),
        ),
    )]
    #[ErrorResponse]
    public function __invoke(Request $request, Article $article, ArticleService $articleService): JsonResponse
    {
        /** @var ArticleRequest $requestArticle */
        $requestArticle = $this->serializer->deserialize(
            $request->getContent(),
            ArticleRequest::class,
            'json',
            (new ObjectNormalizerContextBuilder())
                ->withObjectToPopulate(ArticleRequest::fromEntity($article))
                ->toArray()
        );

        $errors = $this->validator->validate($requestArticle);

        if ($errors->count() > 0) {
            return $this->respondValidationError($errors);
        }

        $article = $articleService->processArticleRequest($requestArticle, $article);

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return $this->json($article, Response::HTTP_OK, [], ['groups' => ['read']]);
    }
}
