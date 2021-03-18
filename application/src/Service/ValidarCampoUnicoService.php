<?php

namespace App\Service;

use App\Controller\AbstractCrudController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ValidarCampoUnicoService extends AbstractCrudController
{
    /**
     * @param $entidade
     * @param array $fields
     * @param string $mensagem
     * @throws \Exception
     */
    public function validar($entidade, array $fields = [], $mensagem = 'registro')
    {
        $repository = $this->getRepository(get_class($entidade));
        $fieldsValidation = new ArrayCollection($fields);

        $fieldsValidation->map(function ($field) use ($entidade, $repository, $mensagem) {

            if (!property_exists($entidade, $field)) {
                throw new \Exception('Campo não passado para validação não encontrado.');
            }

            foreach ($entidade as $key => $row){
                if ($key == $field) {
                    if (is_object($row) && $row->id) {
                        $valor = $row->id;
                        $resultado = $repository->findOneBy(["${field}" => "${valor}"]);
                        $campo = $field;
                    }

                    if (!isset($resultado) && !is_object($row)) {
                        $resultado = $repository->findOneBy(["${field}" => "${row}"]);
                        $campo = $field;
                    }

                    if ($resultado) {
                        throw new \Exception("Este $campo já existe na base de dados.");
                    }
                }
            }
        });
    }
}
