<?php

namespace App\Entity;

use Assert\Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="ps_exemplo.exemplo")
 * @ORM\Entity
 */
class Exemplo extends AbstractEntity
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("public")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("public")
     */
    private $campo1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("public")
     */
    private $campo2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampo1(): ?string
    {
        return $this->campo1;
    }

    public function setCampo1(string $campo1): self
    {
        $this->campo1 = $campo1;

        return $this;
    }

    public function getCampo2(): ?int
    {
        return $this->campo2;
    }

    public function setCampo2(?int $campo2): self
    {
        $this->campo2 = $campo2;

        return $this;
    }

    public function validar() {
        Assert::that($this->campo1)
            ->notNull('Preenchimento obrigatório do campo1');

        Assert::that($this->campo2)
            ->notNull('Preenchimento obrigatório do campo2');
    }
}
