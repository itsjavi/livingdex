<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Repository\LivingDex\PokemonFormRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonFormRepository::class)
 */
class PokemonForm
{
    use AutoIdColumnTrait, GenColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="forms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $basePokemon;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $formPokemon;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReversible;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVolatile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBattleOnly;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class)
     */
    private $fusionPokemon;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class)
     */
    private $requiredItem;

    /**
     * @ORM\ManyToOne(targetEntity=Move::class)
     */
    private $requiredMove;

    /**
     * @ORM\ManyToOne(targetEntity=Ability::class)
     */
    private $requiredAbility;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $requiredConditionOther = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $sortingOrder;

    public function getFormPokemon(): ?Pokemon
    {
        return $this->formPokemon;
    }

    public function setFormPokemon(?Pokemon $formPokemon): self
    {
        $this->formPokemon = $formPokemon;

        return $this;
    }

    public function getBasePokemon(): ?Pokemon
    {
        return $this->basePokemon;
    }

    public function setBasePokemon(?Pokemon $basePokemon): self
    {
        $this->basePokemon = $basePokemon;

        return $this;
    }

    public function isReversible(): ?bool
    {
        return $this->isReversible;
    }

    public function setIsReversible(bool $isReversible): self
    {
        $this->isReversible = $isReversible;

        return $this;
    }

    public function isVolatile(): ?bool
    {
        return $this->isVolatile;
    }

    public function setIsVolatile(bool $isVolatile): self
    {
        $this->isVolatile = $isVolatile;

        return $this;
    }

    public function isBattleOnly(): ?bool
    {
        return $this->isBattleOnly;
    }

    public function setIsBattleOnly(bool $isBattleOnly): self
    {
        $this->isBattleOnly = $isBattleOnly;

        return $this;
    }

    public function getRequiredItem(): ?Item
    {
        return $this->requiredItem;
    }

    public function setRequiredItem(?Item $requiredItem): self
    {
        $this->requiredItem = $requiredItem;

        return $this;
    }

    public function getRequiredMove(): ?Move
    {
        return $this->requiredMove;
    }

    public function setRequiredMove(?Move $requiredMove): self
    {
        $this->requiredMove = $requiredMove;

        return $this;
    }

    public function getRequiredAbility(): ?Ability
    {
        return $this->requiredAbility;
    }

    public function setRequiredAbility(?Ability $requiredAbility): self
    {
        $this->requiredAbility = $requiredAbility;

        return $this;
    }

    public function getRequiredConditionOther(): ?array
    {
        return $this->requiredConditionOther;
    }

    public function setRequiredConditionOther(?array $requiredConditionOther): self
    {
        $this->requiredConditionOther = $requiredConditionOther;

        return $this;
    }

    public function getFusionPokemon(): ?Pokemon
    {
        return $this->fusionPokemon;
    }

    public function setFusionPokemon(?Pokemon $fusionPokemon): self
    {
        $this->fusionPokemon = $fusionPokemon;

        return $this;
    }

    public function getSortingOrder(): ?int
    {
        return $this->sortingOrder;
    }

    public function setSortingOrder(int $sortingOrder): self
    {
        $this->sortingOrder = $sortingOrder;

        return $this;
    }
}
