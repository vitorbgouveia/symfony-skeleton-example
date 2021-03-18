<?php

namespace App\Service;

use App\Controller\AbstractCrudController;
use App\Entity\Exemplo;
use App\Repository\ExemploRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExemploService extends AbstractCrudController
{
    /**
     * @var  ExemploRepository
     */
    private $pessoaFisicaRepository;

    /**
     * @var ValidarCampoUnicoService
     */
    private $validarCampoUnicoService;

    /**
     * PessoaFisicaService constructor.
     * @param ExemploRepository $exemploRepository
     * @param ValidarCampoUnicoService $validarCampoUnicoService
     */
    public function __construct(
        ExemploRepository $exemploRepository,
        ValidarCampoUnicoService $validarCampoUnicoService
    ) {
        $this->pessoaFisicaRepository = $exemploRepository;
        $this->validarCampoUnicoService = $validarCampoUnicoService;
    }

    /**
     * @param $page
     * @return ArrayCollection|JsonResponse
     * @throws \Exception
     */
    public function pesquisarAvancado($data)
    {
        if (!$this->existeColuna(Exemplo::class, $data->get('field'))) {
            throw new \Exception('Campo não encontrado na entidade.');
        }
        return $this->pessoaFisicaRepository->pesquisarAvancado($data);
    }

    /**
     * @param Exemplo $exemplo
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function salvar(Exemplo $exemplo, $fieldsValidation)
    {
        $exemplo->setCamposDefault();

        $exemplo->validar();
        $this->validarCampoUnico($exemplo, $fieldsValidation);
        $this->prepare($exemplo);
        $this->execute();
    }

    /**
     * @param Exemplo $exemplo
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function alterar(Exemplo $exemplo)
    {
        $exemplo->validar();
        $this->merge($exemplo);
        $this->execute();
    }

    /**
     * @throws \Exception
     */
    public function validarCampoUnico($entidade, $fieldsValidation)
    {
        try {
            $this->validarCampoUnicoService->validar($entidade, $fieldsValidation, 'registro');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}