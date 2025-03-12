<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: ArticleTag::class, mappedBy: 'tag', cascade: ['persist', 'remove'], fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Tag
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Tag
    {
        $this->name = $name;

        return $this;
    }

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function setArticles(Collection $articles): Tag
    {
        $this->articles = $articles;

        return $this;
    }
}
