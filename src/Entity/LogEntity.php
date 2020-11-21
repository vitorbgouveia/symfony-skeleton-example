<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity
 */
class LogEntity
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("public")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups("public")
     */
    public $objectId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("public")
     */
    public $objectClass;

    /**
     * @ORM\Column(type="integer")
     * @Groups("public")
     */
    public $usuarioModificacao;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Groups("public")
     */
    public $dataModificacao;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("public")
     */
    public $modificacoes;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("public")
     */
    public $previousObject;

    /**
     * @ORM\Column(type="integer")
     * @Groups("public")
     */
    public $aplicacaoOrigem;

    /**
     * @ORM\Column(type="integer")
     * @Groups("public")
     */
    public $tipo;

    public function setCamposDefault()
    {
        $this->dataModificacao = new \DateTime();
    }

    public function __construct($objectClass, $objectId, $modificacoes, $previousObject, $aplicacaoOrigem, $tipo, $usuarioModificacao)
    {
        $this->objectClass = $objectClass;
        $this->objectId = $objectId;
        $this->modificacoes = $modificacoes;
        $this->previousObject = $previousObject;
        $this->aplicacaoOrigem = $aplicacaoOrigem;
        $this->tipo = $tipo;
        $this->usuarioModificacao = $usuarioModificacao;
        $this->setCamposDefault();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    public function setObjectId(?string $objectId): self
    {
        $this->objectId = $objectId;

        return $this;
    }

    public function getObjectClass(): ?string
    {
        return $this->objectClass;
    }

    public function setObjectClass(string $objectClass): self
    {
        $this->objectClass = $objectClass;

        return $this;
    }

    public function getUsuarioModificacao(): ?int
    {
        return $this->usuarioModificacao;
    }

    public function setUsuarioModificacao(int $usuarioModificacao): self
    {
        $this->usuarioModificacao = $usuarioModificacao;

        return $this;
    }

    public function getDataModificacao(): ?\DateTimeInterface
    {
        return $this->dataModificacao;
    }

    public function setDataModificacao(\DateTimeInterface $dataModificacao): self
    {
        $this->dataModificacao = $dataModificacao;

        return $this;
    }

    public function getModificacoes(): ?string
    {
        return $this->modificacoes;
    }

    public function setModificacoes(?string $modificacoes): self
    {
        $this->modificacoes = $modificacoes;

        return $this;
    }

    public function getPreviousObject(): ?string
    {
        return $this->previousObject;
    }

    public function setPreviousObject(?string $previousObject): self
    {
        $this->previousObject = $previousObject;

        return $this;
    }

    public function getAplicacaoOrigem(): ?int
    {
        return $this->aplicacaoOrigem;
    }

    public function setAplicacaoOrigem(int $aplicacaoOrigem): self
    {
        $this->aplicacaoOrigem = $aplicacaoOrigem;

        return $this;
    }

    public function getTipo(): ?int
    {
        return $this->tipo;
    }

    public function setTipo(int $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }
}
