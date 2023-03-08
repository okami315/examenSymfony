<?php

namespace App\Entity;

use App\Repository\UbicacionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UbicacionRepository::class)]
class Ubicacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $pasillo = null;

    #[ORM\Column]
    private ?int $estanteria = null;

    #[ORM\Column]
    private ?int $estante = null;

    #[ORM\OneToOne(mappedBy: 'ubicacion', cascade: ['persist', 'remove'])]
    private ?Objetos $objetos = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPasillo(): ?int
    {
        return $this->pasillo;
    }

    public function setPasillo(int $pasillo): self
    {
        $this->pasillo = $pasillo;

        return $this;
    }

    public function getEstanteria(): ?int
    {
        return $this->estanteria;
    }

    public function setEstanteria(int $estanteria): self
    {
        $this->estanteria = $estanteria;

        return $this;
    }

    public function getEstante(): ?int
    {
        return $this->estante;
    }

    public function setEstante(int $estante): self
    {
        $this->estante = $estante;

        return $this;
    }

    public function getObjetos(): ?Objetos
    {
        return $this->objetos;
    }

    public function setObjetos(Objetos $objetos): self
    {
        // set the owning side of the relation if necessary
        if ($objetos->getUbicacion() !== $this) {
            $objetos->setUbicacion($this);
        }

        $this->objetos = $objetos;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
