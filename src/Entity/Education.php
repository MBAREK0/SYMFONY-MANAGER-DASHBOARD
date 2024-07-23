<?php

namespace App\Entity;

use App\Repository\EducationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: EducationRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NAME_S_DATE_E_DATE_SCHOOL_SPECIALTY_USER', fields: ['start_date', 'school', 'end_date', 'specialty', 'user'])]
#[Vich\Uploadable]
class Education
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $school = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $degree_fr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $degree_en = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $specialty_fr = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $specialty_en = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_fr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_en = null;


    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_date = null;

    #[Vich\UploadableField(mapping: 'education_image', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'education')]
    private Collection $skills;

    #[ORM\ManyToOne(inversedBy: 'education')]
    private ?User $user = null;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSchool(): ?string
    {
        return $this->school;
    }

    public function setSchool(string $school): static
    {
        $this->school = $school;

        return $this;
    }


    public function getDegreeFr(): ?string
    {
        return $this->degree_fr;
    }

    public function setDegreeFr(?string $degree_fr): static
    {
        $this->degree_fr = $degree_fr;

        return $this;
    }

    public function getDegreeEn(): ?string
    {
        return $this->degree_en;
    }

    public function setDegreeEn(?string $degree_en): static
    {
        $this->degree_en = $degree_en;

        return $this;
    }

    public function getSpecialtyFr(): ?string
    {
        return $this->specialty_fr;
    }

    public function setSpecialtyFr(?string $specialty_fr): static
    {
        $this->specialty_fr = $specialty_fr;

        return $this;
    }

    public function getSpecialtyEn(): ?string
    {
        return $this->specialty_en;
    }

    public function setSpecialtyEn(?string $specialty_en): static
    {
        $this->specialty_en = $specialty_en;

        return $this;
    }

    public function getDescriptionFr(): ?string
    {
        return $this->description_fr;
    }

    public function setDescriptionFr(?string $description_fr): static
    {
        $this->description_fr = $description_fr;

        return $this;
    }

    public function getDescriptionEn(): ?string
    {
        return $this->description_en;
    }

    public function setDescriptionEn(?string $description_en): static
    {
        $this->description_en = $description_en;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }


    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        $this->skills->removeElement($skill);

        return $this;
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
