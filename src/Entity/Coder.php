<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CoderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoderRepository::class)]
#[ApiResource]
class Coder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToMany(targetEntity: Competence::class, inversedBy: 'coders')]
    private Collection $fkCompetence;

    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'coders')]
    private Collection $fkCourse;

    public function __construct()
    {
        $this->fkCompetence = new ArrayCollection();
        $this->fkCourse = new ArrayCollection();
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Competence>
     */
    public function getFkCompetence(): Collection
    {
        return $this->fkCompetence;
    }

    public function addFkCompetence(Competence $fkCompetence): static
    {
        if (!$this->fkCompetence->contains($fkCompetence)) {
            $this->fkCompetence->add($fkCompetence);
        }

        return $this;
    }

    public function removeFkCompetence(Competence $fkCompetence): static
    {
        $this->fkCompetence->removeElement($fkCompetence);

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getFkCourse(): Collection
    {
        return $this->fkCourse;
    }

    public function addFkCourse(Course $fkCourse): static
    {
        if (!$this->fkCourse->contains($fkCourse)) {
            $this->fkCourse->add($fkCourse);
        }

        return $this;
    }

    public function removeFkCourse(Course $fkCourse): static
    {
        $this->fkCourse->removeElement($fkCourse);

        return $this;
    }

    public function __toString()
    {
        return $this->getId(); 
    }
}
