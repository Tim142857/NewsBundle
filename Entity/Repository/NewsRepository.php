<?php

namespace Tleroch\NewsBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use Gedmo\Translatable\TranslatableListener;

class NewsRepository extends EntityRepository
{
    /**
     * Find all active news
     *
     * @param string $locale Locale
     *
     * @return array
     */
    public function findAllActiveWithLocale($locale)  
    {
        $queryBuilder = $this->createQueryBuilder('n');

        $queryBuilder
            ->where('n.active = :active')
            ->setParameter('active', true)
            ->orderBy('n.date_display', 'DESC')
        ;

        $query = $queryBuilder->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $query->setHint(TranslatableListener::HINT_TRANSLATABLE_LOCALE, $locale);

        return $query->getResult();
    }

    /**
     * Find all active news
     *
     * @param string $locale Locale
     *
     * @return array
     */
    public function findAllWithLocale($locale)  
    {
        $queryBuilder = $this->createQueryBuilder('n');

        $queryBuilder
            ->orderBy('n.date_display', 'DESC')
        ;

        $query = $queryBuilder->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $query->setHint(TranslatableListener::HINT_TRANSLATABLE_LOCALE, $locale);

        return $query->getResult();
    }
}
