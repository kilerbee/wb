<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;


class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Article::class);
    }

    public function findArticlesByTags(array $tags): array
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
        ;

        foreach (array_values($tags) as $key => $tagId) {
            $qb
                ->join('a.articleTags', "at$key", Join::WITH, "at$key.tag = :tag$key")
                ->setParameter("tag$key", $tagId)
            ;
        }

        return $qb->getQuery()->getResult();
    }
}
