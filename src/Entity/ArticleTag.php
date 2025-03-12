<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ArticleTag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private readonly \DateTimeInterface $createdAt;

    #[ORM\ManyToOne(targetEntity: Article::class, fetch: 'EAGER', inversedBy: "articleTags")]
    #[ORM\JoinColumn(nullable: false)]
    private Article $article;

    #[ORM\ManyToOne(targetEntity: Tag::class, fetch: 'EAGER', inversedBy: "articleTags")]
    #[ORM\JoinColumn(nullable: false)]
    private Tag $tag;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): ArticleTag
    {
        $this->id = $id;
        return $this;
    }

    public function getArticle(): Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): ArticleTag
    {
        $this->article = $article;
        return $this;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }

    public function setTag(Tag $tag): ArticleTag
    {
        $this->tag = $tag;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
