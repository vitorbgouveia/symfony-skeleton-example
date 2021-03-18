<?php

namespace App\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class AbstractCrudController extends AbstractController
{
    /**
     * @var string
     */
    private $entidade;
    /**
     * @var array
     */
    private $fieldsValidation;

    /**
     * @return string
     */
    public function getEntidade(): string
    {
        return $this->entidade;
    }

    /**
     * @param string $entidade
     */
    public function setEntidade(string $entidade): void
    {
        $this->entidade = $entidade;
    }

    /**
     * @return array
     */
    public function getFieldsValidation()
    {
        return $this->fieldsValidation;
    }

    /**
     * @param array $fieldsValidation
     */
    public function setFieldsValidation(array $fieldsValidation): void
    {
        $this->fieldsValidation = $fieldsValidation;
    }

    /**
     * @return \Doctrine\Persistence\ObjectRepository
     */
    public function getRepository($entidade = null)
    {
        $entidade = $entidade ? $entidade : $this->getEntidade();
        return $this->getDoctrine()
            ->getRepository($entidade);
    }

    /**
     * @param int $id
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function delete(int $id)
    {
        try {
            $entidade = $this->getRepository()->find($id);
            if (!$entidade) {
                throw new \Exception('Nenhum registro encontrado.');
            }
            $pessoa = $this->getRepository('App\Entity\Pessoa')->find($entidade->idPessoa->id);
            $this->getDoctrine()->getManager()->remove($pessoa);
            $this->getDoctrine()->getManager()->flush();
        } catch (\Exception $exception) {
            return $this->json(['message' => $exception->getMessage()], 400);
        }
        return $this->sucessResponse('','Deletado com sucesso!');
    }

    /**
     * @param $resultado
     * @param null $message
     * @param array $groups
     * @return JsonResponse
     */
    public function sucessResponse($resultado, $message = null, $groups = ['public']) {
        $response = new ArrayCollection([
            'message' => $message,
            'data' => $resultado
        ]);
        return $this->json($response, 200, [], [
            ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) { return $object->id; },
            ObjectNormalizer::GROUPS => $groups
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse|Response
     * @throws \Exception
     */
    public function consultarHistorico(int $id)
    {
        $logRepo = $this->getRepository('App\Entity\LogEntity');
        try {
            $logs = $logRepo
                ->findBy(['objectClass' => $this->getEntidade(), 'objectId' => $id], ['dataModificacao' => "DESC"]);
            if (!$logs) {
                throw new \Exception('Nenhum histórico encontrado.');
            }
        } catch (\Exception $exception) {
            return $this->json(['message' => $exception->getMessage()], 400);
        }
        return $this->sucessResponse($logs,'Consulta realizada!');
    }

    /**
     * @param $entidade
     * @param $coluna
     * @return bool
     */
    public function existeColuna($entidade, $coluna) {
        return property_exists($entidade, $coluna);
    }

    public function execute()
    {
        $this->getDoctrine()->getManager()->flush();
    }

    /**
     * @param $object
     */
    public function merge($object)
    {
        $this->getDoctrine()->getManager()->merge($object);
    }

    /**
     * @param $object
     */
    public function prepare($object)
    {
        $this->getDoctrine()->getManager()->persist($object);
    }

    /**
     * @param $object
     */
    public function remove($object)
    {
        $this->getDoctrine()->getManager()->remove($object);
    }
}