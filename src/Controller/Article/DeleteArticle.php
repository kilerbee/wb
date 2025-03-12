<?php

namespace App\Controller\Article;

use App\Controller\BaseController;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

final class DeleteArticle extends BaseController
{
    #[Route('/api/articles/{article}', name: 'delete_article', methods: ['DELETE'])]
    #[OA\Tag(name: 'Articles')]
    public function __invoke(Article $article): Response
    {
        $this->entityManager->remove($article);
        $this->entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
