<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class ArticleRepository extends EntityRepository
{
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
