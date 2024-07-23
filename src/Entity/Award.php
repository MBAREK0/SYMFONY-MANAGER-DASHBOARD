<?php

namespace App\Entity;

use App\Repository\AwardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AwardRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_TITLE_ASS_W_DATE_USER', fields: ['title', 'associated_with', 'date', 'user'])]
#[Vich\Uploadable]
class Award
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title_en = null;

    #[ORM\Column(length: 255)]
    private ?string $title_fr = null;

    #[ORM\Column(length: 255)]
    private ?string $issuingOrganization_en = null;

    #[ORM\Column(length: 255)]
    private ?string $issuingOrganization_fr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_en = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_fr = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[Vich\UploadableField(mapping: 'award_image', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'awards')]
    private ?User $user = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleEn(): ?string
    {
        return $this->title_en;
    }

    public function setTitleEn(?string $title_en): void
    {
        $this->title_en = $title_en;
    }

    public function getTitleFr(): ?string
    {
        return $this->title_fr;
    }

    public function setTitleFr(?string $title_fr): void
    {
        $this->title_fr = $title_fr;
    }

    public function getIssuingOrganizationEn(): ?string
    {
        return $this->issuingOrganization_en;
    }

    public function setIssuingOrganizationEn(?string $issuingOrganization_en): void
    {
        $this->issuingOrganization_en = $issuingOrganization_en;
    }

    public function getIssuingOrganizationFr(): ?string
    {
        return $this->issuingOrganization_fr;
    }

    public function setIssuingOrganizationFr(?string $issuingOrganization_fr): void
    {
        $this->issuingOrganization_fr = $issuingOrganization_fr;
    }

    public function getDescriptionEn(): ?string
    {
        return $this->description_en;
    }

    public function setDescriptionEn(?string $description_en): void
    {
        $this->description_en = $description_en;
    }

    public function getDescriptionFr(): ?string
    {
        return $this->description_fr;
    }

    public function setDescriptionFr(?string $description_fr): void
    {
        $this->description_fr = $description_fr;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

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
