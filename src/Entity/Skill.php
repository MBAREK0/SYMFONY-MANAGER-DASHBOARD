<?php

// src/Entity/Skill.php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
#[Vich\Uploadable]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NAME_USER', fields: ['name', 'user'])]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Vich\UploadableField(mapping: 'skill_image', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'technologies')]
    private Collection $projects;

    /**
     * @var Collection<int, Education>
     */
    #[ORM\ManyToMany(targetEntity: Education::class, mappedBy: 'skills')]
    private Collection $education;

    /**
     * @var Collection<int, Award>
     */
    #[ORM\ManyToMany(targetEntity: Award::class, mappedBy: 'skills')]
    private Collection $awards;

    /**
     * @var Collection<int, LicenseAndCertification>
     */
    #[ORM\ManyToMany(targetEntity: LicenseAndCertification::class, mappedBy: 'skills')]
    private Collection $licenseAndCertifications;

    /**
     * @var Collection<int, Experience>
     */
    #[ORM\ManyToMany(targetEntity: Experience::class, mappedBy: 'technologies_used')]
    private Collection $experiences;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->education = new ArrayCollection();
        $this->awards = new ArrayCollection();
        $this->licenseAndCertifications = new ArrayCollection();
        $this->experiences = new ArrayCollection();
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

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addTechnology($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            $project->removeTechnology($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducation(): Collection
    {
        return $this->education;
    }

    public function addEducation(Education $education): static
    {
        if (!$this->education->contains($education)) {
            $this->education->add($education);
            $education->addSkill($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): static
    {
        if ($this->education->removeElement($education)) {
            $education->removeSkill($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Award>
     */
    public function getAwards(): Collection
    {
        return $this->awards;
    }

    public function addAward(Award $award): static
    {
        if (!$this->awards->contains($award)) {
            $this->awards->add($award);
            $award->addSkill($this);
        }

        return $this;
    }

    public function removeAward(Award $award): static
    {
        if ($this->awards->removeElement($award)) {
            $award->removeSkill($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, LicenseAndCertification>
     */
    public function getLicenseAndCertifications(): Collection
    {
        return $this->licenseAndCertifications;
    }

    public function addLicenseAndCertification(LicenseAndCertification $licenseAndCertification): static
    {
        if (!$this->licenseAndCertifications->contains($licenseAndCertification)) {
            $this->licenseAndCertifications->add($licenseAndCertification);
            $licenseAndCertification->addSkill($this);
        }

        return $this;
    }

    public function removeLicenseAndCertification(LicenseAndCertification $licenseAndCertification): static
    {
        if ($this->licenseAndCertifications->removeElement($licenseAndCertification)) {
            $licenseAndCertification->removeSkill($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->addTechnologiesUsed($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            $experience->removeTechnologiesUsed($this);
        }

        return $this;
    }
}
