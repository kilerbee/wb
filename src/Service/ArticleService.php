<?php

namespace App\Service;

use App\DTO\ArticleRequest;
use App\Entity\Article;
use App\Entity\ArticleTag;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;

final readonly class ArticleService
{
    public function __construct(
        private TagRepository $tagRepository,
        private ArticleRepository $articleRepository,
    ) {
    }

    public function processArticleQuery(array $tagsFilter): array
    {
        $tagsFilter = array_filter($tagsFilter, fn ($tag) => is_int($tag));

        return $this->articleRepository->findArticlesByTags(array_values($tagsFilter));
    }

    public function processArticleRequest(ArticleRequest $articleRequest, ?Article $article = null): Article
    {
        if (null === $article) {
            $article = new Article();
        }

        $article->setName($articleRequest->name);

        $this->processTags($article, $articleRequest->tags);

        return $article;
    }

    private function processTags(Article $article, array $tagIdList): void
    {
        $incomingTags = new ArrayCollection($this->resolveTags($tagIdList));

        $articleTagsToBeRemoved = $article->getArticleTags()->filter(
            fn (ArticleTag $articleTag) => !$incomingTags->contains($articleTag->getTag()),
        );


        $existingTags = $article->getArticleTags()->map(
            fn (ArticleTag $articleTag) => $articleTag->getTag(),
        );

        $articleTagsToBeAdded = $incomingTags
            ->filter(fn (Tag $tag) => !$existingTags->contains($tag))
            ->map(fn (Tag $tag) => (new ArticleTag())->setTag($tag))
        ;

        foreach ($articleTagsToBeRemoved as $articleTag) {
            $article->removeArticleTag($articleTag);
        }

        foreach ($articleTagsToBeAdded as $tag) {
            $article->addArticleTag($tag);
        }
    }

    private function resolveTags(array $tagIdList): array
    {
        return $this->tagRepository->findBy(['id' => $tagIdList]);
    }
}
