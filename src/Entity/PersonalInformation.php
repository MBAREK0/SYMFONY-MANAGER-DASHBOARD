<?php

namespace App\Entity;

use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonalInformationRepository::class)]
class PersonalInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nickName = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $about_en = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $about_fr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $position_en = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $position_fr = null;

    #[ORM\OneToOne(mappedBy: 'PersonalInformation', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $current_role_en = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $current_role_fr = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(?string $nickName): static
    {
        $this->nickName = $nickName;

        return $this;
    }

    public function getAboutEn(): ?string
    {
        return $this->about_en;
    }

    public function setAboutEn(?string $about_en): static
    {
        $this->about_en = $about_en;

        return $this;
    }

    public function getAboutFr(): ?string
    {
        return $this->about_fr;
    }

    public function setAboutFr(?string $about_fr): static
    {
        $this->about_fr = $about_fr;

        return $this;
    }

    public function getPositionEn(): ?string
    {
        return $this->position_en;
    }

    public function setPositionEn(?string $position_en): static
    {
        $this->position_en = $position_en;

        return $this;
    }

    public function getPositionFr(): ?string
    {
        return $this->position_fr;
    }

    public function setPositionFr(?string $position_fr): static
    {
        $this->position_fr = $position_fr;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        // set the owning side of the relation if necessary
        if ($user->getPersonalInformation() !== $this) {
            $user->setPersonalInformation($this);
        }

        $this->user = $user;

        return $this;
    }


    public function getCurrentRoleEn(): ?string
    {
        return $this->current_role_en;
    }

    public function setCurrentRoleEn(?string $current_role_en): static
    {
        $this->current_role_en = $current_role_en;

        return $this;
    }

    public function getCurrentRoleFr(): ?string
    {
        return $this->current_role_fr;
    }

    public function setCurrentRoleFr(?string $current_role_fr): static
    {
        $this->current_role_fr = $current_role_fr;

        return $this;
    }

    // public function __toString(): string
    // {
    //     return $this->getFirstName() . ' ' . $this->getLastName();
    // }
    // public function generatePresentation(): string
    // {
    //     $presentation = "My name is {$this->getFirstName()} {$this->getLastName()}.\n";
    //     $presentation .= "I am currently working as {$this->getCurrentRoleEn()}.\n";
    //     $presentation .= "Here is a little bit about me:\n";
    //     $presentation .= "{$this->getAboutEn()}\n";
    //     $presentation .= "My position is {$this->getPositionEn()}.\n";
    //     return $presentation;
    // }
}
