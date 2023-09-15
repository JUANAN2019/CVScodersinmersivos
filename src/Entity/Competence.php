<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
#[ApiResource]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Level $fkLevel = null;

    #[ORM\ManyToMany(targetEntity: Coder::class, mappedBy: 'fkCompetence')]
    private Collection $coders;

    public function __construct()
    {
        $this->coders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFkLevel(): ?Level
    {
        return $this->fkLevel;
    }

    public function setFkLevel(Level $fkLevel): static
    {
        $this->fkLevel = $fkLevel;

        return $this;
    }

    /**
     * @return Collection<int, Coder>
     */
    public function getCoders(): Collection
    {
        return $this->coders;
    }

    public function addCoder(Coder $coder): static
    {
        if (!$this->coders->contains($coder)) {
            $this->coders->add($coder);
            $coder->addFkCompetence($this);
        }

        return $this;
    }

    public function removeCoder(Coder $coder): static
    {
        if ($this->coders->removeElement($coder)) {
            $coder->removeFkCompetence($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getId(); 
    }
}
