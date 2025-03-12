<?php

namespace App\DTO;

use App\Entity\Article;
use Symfony\Component\Serializer\Attribute\Groups;
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
                fn ($articleTag) => $articleTag->getTag()->getId(),
            )->toArray(),
        );
    }
}
