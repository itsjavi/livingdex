<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\IdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Entity\LivingDex\ColumnTrait\SlugColumnTrait;
use App\Repository\LivingDex\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    use IdColumnTrait, GenColumnTrait, SlugColumnTrait, NameColumnTrait;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $showdownName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $veekunName;

    /**
     * @ORM\OneToMany(targetEntity=PokemonItem::class, mappedBy="item")
     */
    private $wildHeldPokemon;

    /**
     * @ORM\OneToMany(targetEntity=ItemText::class, mappedBy="item")
     */
    private $texts;

    public function __construct()
    {
        $this->wildHeldPokemon = new ArrayCollection();
        $this->texts = new ArrayCollection();
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

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
     * @return Collection|PokemonItem[]
     */
    public function getWildHeldPokemon(): Collection
    {
        return $this->wildHeldPokemon;
    }

    public function addWildHeldPokemon(PokemonItem $wildHeldPokemon): self
    {
        if (!$this->wildHeldPokemon->contains($wildHeldPokemon)) {
            $this->wildHeldPokemon[] = $wildHeldPokemon;
            $wildHeldPokemon->setItem($this);
        }

        return $this;
    }

    /**
     * @return Collection|ItemText[]
     */
    public function getTexts(): Collection
    {
        return $this->texts;
    }

    public function addText(ItemText $text): self
    {
        if (!$this->texts->contains($text)) {
            $this->texts[] = $text;
            $text->setItem($this);
        }

        return $this;
    }
}
