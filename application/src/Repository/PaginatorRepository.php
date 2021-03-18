<?php

namespace App\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

trait PaginatorRepository
{
    /**
     * @var int
     */
    public $pageSize;

    /**
     * @param $query
     * @param int $currentPage
     * @param int $pageSize
     * @return Paginator
     */
    public function paginacao($query, $paramPage)
    {
        $paginator = new Paginator($query, false);
        $page = intval($paramPage->get('page'));

        $paginator->getQuery()
            ->setFirstResult($paramPage->get('size') * ($page - 1)) // Offset
            ->setMaxResults(intval($paramPage->get('size'))); // Limit

        return $paginator;
    }

    /**
     * @param Paginator $paginator
     * @param array $paginaAtual
     * @return int
     */
    public function getProximaPagina(Paginator $paginator, $paramPage)
    {
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $paginator->getQuery()->getMaxResults());
        $proximaPagina = intval($paramPage->get('page')) + 1 <= $pagesCount ? intval($paramPage->get('page')) + 1 : intval($paramPage->get('page'));
        $this->pageSize = intval($paramPage->get('size'));

        return $proximaPagina;
    }
}
