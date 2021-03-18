<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/** @MappedSuperclass */
class AbstractEntity
{
    /**
     * @var DateTime|null
     * @ORM\Column(name="dt_criacao", type="datetime", nullable=true)
     * @Groups("private")
     */
    public $dtCriacao;

    /**
     * @var int|null
     * @ORM\Column(name="aplicacao_origem", type="integer", nullable=true)
     * @Groups("private")
     * Campo representa id do módulo(Front) que realizou a requisição
     */
    public $aplicacaoOrigem;

    /**
     * @ORM\Column(type="integer")
     * @Groups("private")
     */
    public $usuarioCriacao;

    /**
     * Seta os campos padrões
     */
    public function setCamposDefault()
    {
        $this->dtCriacao = new \DateTime();
    }
}