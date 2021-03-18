<?php

namespace App\Controller;

use App\Entity\Exemplo;
use App\Repository\ExemploRepository;
use App\Service\ExemploService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ExemploController extends AbstractCrudController
{
    /**
     * @var ExemploRepository
     */
    private  $repository;

    /**
     * @var ExemploService
     */
    private $service;

    public function __construct(
        ExemploService $service,
        ExemploRepository $repository
    )
    {
        $this->repository = $repository;
        $this->service = $service;
        parent::setEntidade('App\Entity\Exemplo');
        parent::setFieldsValidation(['campo1', 'campo2']);
    }

    /**
     * @Route("/exemplo", name="exemplo_inserir", methods={"POST"})
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function inserir(Request $request, SerializerInterface $serializer)
    {
        try {
            /** @var Exemplo $exemplo */
            $exemplo = $serializer->deserialize($request->getContent(), $this->getEntidade(), 'json');
            $this->service->salvar($exemplo, $this->getFieldsValidation());
        } catch (\Exception $exception) {
            return $this->json(['message' => $exception->getMessage()], 400);
        }
        return $this->sucessResponse($exemplo,'Cadastrado com sucesso!');
    }

    /**
     * @Route("/exemplo", name="exemplo_alterar", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function alterar(Request $request, SerializerInterface $serializer)
    {
        try {
            /** @var Exemplo $exemplo */
            $exemplo = $serializer->deserialize($request->getContent(), $this->getEntidade(), 'json');
            $this->service->alterar($exemplo);
        } catch (\Exception $exception) {
            return $this->json(['message' => $exception->getMessage()], 400);
        }
        return $this->sucessResponse($exemplo,'Alterado com sucesso!');
    }

    /**
     * @Route("/exemplo/{id}", name="exemplo_deletar", methods={"DELETE"})
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function deletar(Request $request)
    {
        $id = (int) $request->get('id');
        return parent::delete($id);
    }

    /**
     * @Route("/pessoa-fisica/consultar-historico/{id}", name="pessoa_fisica_consultar_historico", methods={"GET"})
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function consultarLog(Request $request)
    {
        $id = (int) $request->get('id');
        return parent::consultarHistorico($id);
    }

    /**
     * @Route("/exemplo/pesquisar-avancado", name="exemplo_avancado", methods={"GET"})
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function pesquisarAvancado(Request $request)
    {
        $data = array($request->query)[0];
        try {
            $resultado = $this->service->pesquisarAvancado($data);
        } catch (\Exception $exception) {
            return $this->json(['message' => $exception->getMessage()], 400);
        }

        return $this->sucessResponse($resultado,'Consulta realizada!');
    }

    /**
     * @Route("/exemplo/consultar-por-parametro", name="exemplo_consultar_por_parametro", methods={"GET"})
     * @param Request $request
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function consultarPorParametro(Request $request)
    {
        $data = array($request->query)[0];
        try {
            if (!$this->existeColuna(Exemplo::class, $data->get('field'))) {
                throw new Exception('Campo não encontrado na entidade.');
            }
            $entidade = $this->repository->consultarParametro($data);
            if (!$entidade) {
                throw new Exception('Nenhum registro encontrado.');
            }
        } catch (\Exception $exception) {
            return $this->json(['message' => $exception->getMessage()], 400);
        }
        return $this->sucessResponse($entidade,'Consulta realizada!');
    }

    /**
     * @Route("/exemplo/props", name="exemplo_props", methods={"GET"})
     */
    public function props()
    {
        return $this->json(
            [
                'campo1'  => ['pesquisavel' => true, 'obrigatorio' => true, 'label' => 'campo1', 'colunaTabela' => true, 'objectChildren' => ['entidade'], 'pesquisarPorFilho' => true],
                'campo2'  => ['pesquisavel' => true, 'obrigatorio' => true, 'label' => 'campo2', 'colunaTabela' => true, 'objectChildren' => ['entidade2'], 'pesquisarPorFilho' => true],
            ]
        );
    }
}