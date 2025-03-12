<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\OneToMany(
        targetEntity: ArticleTag::class,
        mappedBy: 'article',
        cascade: ['persist', 'remove'],
        orphanRemoval: true,
    )]
    private Collection $articleTags;

    public function __construct()
    {
        $this->articleTags = new ArrayCollection();
    }

    #[Groups(['read'])]
    /**
     * @return array<Tag>
     */
    public function getTags(): array
    {
        return $this->articleTags->map(fn (ArticleTag $articleTag) => $articleTag->getTag())->getValues();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Article
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Article
    {
        $this->name = $name;

        return $this;
    }

    public function getArticleTags(): Collection
    {
        return $this->articleTags;
    }

    public function addArticleTag(ArticleTag $articleTag): self
    {
        if (!$this->articleTags->contains($articleTag)) {
            $articleTag->setArticle($this);
            $this->articleTags->add($articleTag);
        }

        return $this;
    }

    public function removeArticleTag(ArticleTag $articleTag): self
    {
        if ($this->articleTags->contains($articleTag)) {
            $this->articleTags->removeElement($articleTag);
        }

        return $this;
    }
}
