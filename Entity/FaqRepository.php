<?php

namespace Awaresoft\FaqBundle\Entity;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Sonata\PageBundle\Model\SiteInterface;

/**
 * Class FaqRepository
 *
 * @author Bartosz Malec <b.malec@awaresoft.pl>
 */
class FaqRepository extends NestedTreeRepository
{
    /**
     * @return Faq[]
     */
    public function findAllEnabled()
    {
        return $this->findBy(['enabled' => 1], ['left' => 'ASC']);
    }

    /**
     * @param SiteInterface $site
     * @param null $level
     * @param null $limit
     *
     * @return Faq[]
     */
    public function findEnabled(SiteInterface $site, $level = null, $limit = null)
    {
        $qb = $this->createQueryBuilder('f')
            ->where('f.enabled = :enabled')
            ->andWhere('f.site = :site')
            ->setParameter('enabled', true)
            ->setParameter('site', $site);

        if (null !== $level) {
            $qb
                ->andWhere('f.level = :level')
                ->setParameter('level', $level);
        }

        $qb->orderBy('f.left', 'ASC');

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Faq $excludedFaq
     *
     * @return Faq[]
     */
    public function findOthers(Faq $excludedFaq)
    {
        $qb = $this->createQueryBuilder('f');
        $qb
            ->where('f.id != :identifier')
            ->andWhere('f.enabled = :enabled')
            ->andWhere('f.parent = :parent')
            ->setParameter('identifier', $excludedFaq->getId())
            ->setParameter('enabled', true)
            ->setParameter('parent', $excludedFaq->getParent())
            ->addOrderBy('f.left', 'ASC');

        return $qb->getQuery()->getResult();
    }
}