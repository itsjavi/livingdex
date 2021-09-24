<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\IdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Entity\LivingDex\ColumnTrait\SlugColumnTrait;
use App\Repository\LivingDex\AbilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @ORM\Entity(repositoryClass=AbilityRepository::class)
 */
class Ability implements Arrayable
{
    use IdColumnTrait, GenColumnTrait, SlugColumnTrait, NameColumnTrait;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $rating;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $showdownName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $veekunName;

    /**
     * @ORM\OneToMany(targetEntity=AbilityText::class, mappedBy="ability")
     */
    private $texts;

    public function __construct()
    {
        $this->texts = new ArrayCollection();
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getShowdownName(): ?string
    {
        return $this->showdownName;
    }

    public function setShowdownName(?string $showdownName): self
    {
        $this->showdownName = $showdownName;

        return $this;
    }

    public function getVeekunName(): ?string
    {
        return $this->veekunName;
    }

    public function setVeekunName(?string $veekunName): self
    {
        $this->veekunName = $veekunName;

        return $this;
    }

    /**
     * @return Collection|AbilityText[]
     */
    public function getTexts(): Collection
    {
        return $this->texts;
    }

    public function addText(AbilityText $text): self
    {
        if (!$this->texts->contains($text)) {
            $this->texts[] = $text;
            $text->setAbility($this);
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'slug' => $this->getSlug(),
            'gen' => $this->getGen(),
            'rating' => $this->getRating(),
            'showdownName' => $this->getShowdownName(),
            'veekunName' => $this->getVeekunName(),
        ];
    }
}
