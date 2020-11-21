<?php

namespace App\Repository;

use App\Entity\Exemplo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Exemplo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exemplo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exemplo[]    findAll()
 * @method Exemplo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExemploRepository extends ServiceEntityRepository
{
    use PaginatorRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exemplo::class);
    }

    /**
     * @param $data
     * @return ArrayCollection
     * @throws \Exception
     */
    public function pesquisarAvancado($data)
    {
        if (!$data->get('campo2')) {
            $query = $this->createQueryBuilder('exemplo')
                ->andWhere("lower(exemplo.campo1) LIKE :val")
                ->setParameter('val', "%{$data->get('campo2')}%")
                ->orderBy("exemplo.campo2", 'ASC')
                ->getQuery();
        }

        if (empty($query)) {
            $query = $this->createQueryBuilder('exemplo')
                ->andWhere("lower(exemplo.campo1) = :val")
                ->setParameter('val', "{$data->get('campo1')}")
                ->orderBy("exemplo.campo1", 'ASC')
                ->getQuery();
        }

        $paginator = $this->paginacao($query, $data);

        return new ArrayCollection([
            'resultado' => new ArrayCollection($paginator->getIterator()->getArrayCopy()),
            'proximaPagina' => $this->getProximaPagina($paginator, $data),
            'paramsPaginator' => [$paginator->count(), $this->pageSize]
        ]);
    }

    /**
     * @param $data
     * @return mixed|object|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function consultarParametro($data)
    {
        if ($data->get('field') == 'id') {
            return $this->getEntityManager()->
            getRepository(Exemplo::class)->
            find($data->get('value'));
        }

        $result = $this->createQueryBuilder('exemplo')
            ->andWhere("lower(exemplo.{$data->get('field')}) = :val")
            ->setParameter('val', $data->get('value'))
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }
}
