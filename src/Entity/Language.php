<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NAME_USER', fields: ['name_en', 'user'])]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_en = null;

    #[ORM\Column(length: 255)]
    private ?string $name_fr = null;

    #[ORM\Column(length: 255)]
    private ?string $proficiency_en = null;

    #[ORM\Column(length: 255)]
    private ?string $proficiency_fr = null;

    #[ORM\ManyToOne(inversedBy: 'languages')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEn(): ?string
    {
        return $this->name_en;
    }

    public function setNameEn(?string $name_en): void
    {
        $this->name_en = $name_en;
    }

    public function getNameFr(): ?string
    {
        return $this->name_fr;
    }

    public function setNameFr(?string $name_fr): void
    {
        $this->name_fr = $name_fr;
    }

    public function getProficiencyEn(): ?string
    {
        return $this->proficiency_en;
    }

    public function setProficiencyEn(?string $proficiency_en): void
    {
        $this->proficiency_en = $proficiency_en;
    }

    public function getProficiencyFr(): ?string
    {
        return $this->proficiency_fr;
    }

    public function setProficiencyFr(?string $proficiency_fr): void
    {
        $this->proficiency_fr = $proficiency_fr;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
