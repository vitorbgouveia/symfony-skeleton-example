<?php

namespace App\Service;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

trait LogTrait
{

    /**
     * @param array $changeSets
     * @param $entidade
     * @return array
     * @throws \Exception
     */
    public function getUpdateLogMessage(array $changeSets, $entidade): array
    {
        $mensagensLog = new ArrayCollection();
        $serializers = new Serializer( [new ObjectNormalizer()], [new JsonEncoder()] );
        $entidade = $serializers->serialize($entidade, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->id;
            }
        ]);
        $entidade = json_decode($entidade, true);


        foreach ($changeSets as $property => $changeSet) {
            for ($i = 0, $s = sizeof($changeSet); $i < $s; $i++) {
                if ($changeSet[$i] instanceof DateTime) {
                    $changeSet[$i] = $changeSet[$i]->format('Y-m-d H:i:s.u');
                }
            }

            if ($changeSet[0] !== $changeSet[1]) {
                $changeSet[0] = gettype($changeSet[0]) == 'object' ? $changeSet[0]->id : $changeSet[0];
                $changeSet[1] = gettype($changeSet[1]) == 'object' ? $changeSet[1]->id : $changeSet[1];
                $entidade[$property] = $changeSet[0];
                $mensagensLog->add(sprintf(
                        '%s #%d : campo "%s" modificado de "%s" para "%s"',
                        self::class,
                        $this->getId(),
                        $property,
                        ! is_array($changeSet[0]) ? $changeSet[0] : 'an array',
                        ! is_array($changeSet[1]) ? $changeSet[1] : 'an array'
                    ));
            };
        }
        $mensagensLog = implode(' :: ', $mensagensLog->getIterator()->getArrayCopy());
        return [$mensagensLog, json_encode($entidade)];

    }
}
