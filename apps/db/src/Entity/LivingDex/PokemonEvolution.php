<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Repository\LivingDex\PokemonEvolutionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonEvolutionRepository::class)
 */
class PokemonEvolution
{
    use AutoIdColumnTrait, GenColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="pokemonEvolutions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fromPokemon;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="evolutions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $toPokemon;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $evoMethod;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $evoLevel;

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

    public function getToPokemon(): ?Pokemon
    {
        return $this->toPokemon;
    }

    public function setToPokemon(?Pokemon $toPokemon): self
    {
        $this->toPokemon = $toPokemon;

        return $this;
    }

    public function getFromPokemon(): ?Pokemon
    {
        return $this->fromPokemon;
    }

    public function setFromPokemon(?Pokemon $fromPokemon): self
    {
        $this->fromPokemon = $fromPokemon;

        return $this;
    }

    public function getEvoMethod(): ?string
    {
        return $this->evoMethod;
    }

    public function setEvoMethod(string $evoMethod): self
    {
        $this->evoMethod = $evoMethod;

        return $this;
    }

    public function getEvoLevel(): ?int
    {
        return $this->evoLevel;
    }

    public function setEvoLevel(int $evoLevel): self
    {
        $this->evoLevel = $evoLevel;

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
