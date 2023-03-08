<?php

namespace App\Entity;

use App\Repository\EntradasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntradasRepository::class)]
class Entradas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'entradas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Objetos $objetos = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getObjetos(): ?Objetos
    {
        return $this->objetos;
    }

    public function setObjetos(?Objetos $objetos): self
    {
        $this->objetos = $objetos;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
