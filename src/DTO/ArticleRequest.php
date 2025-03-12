<?php

namespace App\DTO;

use App\Entity\Article;
use App\Entity\ArticleTag;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleRequest
{
    public function __construct(
        #[Assert\Length(min: 1, max: 255)]
        public string $name = '',

        /**
         * @var array<int>
         */
        public array $tags = [],
    ) {
    }

    public static function fromEntity(Article $article): self
    {
        return new self(
            name: $article->getName(),
            tags: $article->getArticleTags()->map(
                fn (ArticleTag $articleTag) => $articleTag->getTag()->getId(),
            )->toArray(),
        );
    }
}
