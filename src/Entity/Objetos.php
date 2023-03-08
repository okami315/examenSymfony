<?php

namespace App\Entity;

use App\Repository\ObjetosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjetosRepository::class)]
class Objetos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\OneToOne(inversedBy: 'objetos', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ubicacion $ubicacion = null;

    #[ORM\OneToMany(mappedBy: 'objetos', targetEntity: Entradas::class, orphanRemoval: true)]
    private Collection $entradas;

    #[ORM\OneToMany(mappedBy: 'objetos', targetEntity: Salidas::class, orphanRemoval: true)]
    private Collection $salidas;

    public function __construct()
    {
        $this->entradas = new ArrayCollection();
        $this->salidas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function getUbicacion(): ?Ubicacion
    {
        return $this->ubicacion;
    }

    public function setUbicacion(Ubicacion $ubicacion): self
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * @return Collection<int, Entradas>
     */
    public function getEntradas(): Collection
    {
        return $this->entradas;
    }

    public function addEntrada(Entradas $entrada): self
    {
        if (!$this->entradas->contains($entrada)) {
            $this->entradas->add($entrada);
            $entrada->setObjetos($this);
        }

        return $this;
    }

    public function removeEntrada(Entradas $entrada): self
    {
        if ($this->entradas->removeElement($entrada)) {
            // set the owning side to null (unless already changed)
            if ($entrada->getObjetos() === $this) {
                $entrada->setObjetos(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Salidas>
     */
    public function getSalidas(): Collection
    {
        return $this->salidas;
    }

    public function addSalida(Salidas $salida): self
    {
        if (!$this->salidas->contains($salida)) {
            $this->salidas->add($salida);
            $salida->setObjetos($this);
        }

        return $this;
    }

    public function removeSalida(Salidas $salida): self
    {
        if ($this->salidas->removeElement($salida)) {
            // set the owning side to null (unless already changed)
            if ($salida->getObjetos() === $this) {
                $salida->setObjetos(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->description;
    }
}
