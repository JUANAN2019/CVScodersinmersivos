<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[ApiResource]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\ManyToMany(targetEntity: Coder::class, mappedBy: 'fkCourse')]
    private Collection $coders;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    private ?Bootcamp $fkBootcamp = null;

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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

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
            $coder->addFkCourse($this);
        }

        return $this;
    }

    public function removeCoder(Coder $coder): static
    {
        if ($this->coders->removeElement($coder)) {
            $coder->removeFkCourse($this);
        }

        return $this;
    }

    public function getFkBootcamp(): ?Bootcamp
    {
        return $this->fkBootcamp;
    }

    public function setFkBootcamp(?Bootcamp $fkBootcamp): static
    {
        $this->fkBootcamp = $fkBootcamp;

        return $this;
    }

    public function __toString()
    {
        return $this->getId(); 
    }
}
