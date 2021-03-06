<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LieuRepository::class)
 */
class Lieu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Le lieu doit avoir un nom")
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner votre rue")
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner la latitude")
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner la longitude")
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity=Sortie::class, mappedBy="noLieu")
     */
    private $sorties;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="lieus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $noVille;

    public function __construct()
    {
        $this->sorties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties[] = $sorty;
            $sorty->setNoLieu($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): self
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getNoLieu() === $this) {
                $sorty->setNoLieu(null);
            }
        }

        return $this;
    }

    public function getNoVille(): ?Ville
    {
        return $this->noVille;
    }

    public function setNoVille(?Ville $noVille): self
    {
        $this->noVille = $noVille;

        return $this;
    }
}
