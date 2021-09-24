<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Repository\LivingDex\PokemonItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonItemRepository::class)
 */
class PokemonItem
{
    use AutoIdColumnTrait, GenColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="wildHeldItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pokemon;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="wildHeldPokemon")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity=GameGroup::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameGroup;

    /**
     * @ORM\Column(type="integer")
     */
    private $probability;

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getGameGroup(): ?GameGroup
    {
        return $this->gameGroup;
    }

    public function setGameGroup(?GameGroup $gameGroup): self
    {
        $this->gameGroup = $gameGroup;

        return $this;
    }

    public function getProbability(): ?int
    {
        return $this->probability;
    }

    public function setProbability(int $probability): self
    {
        $this->probability = $probability;

        return $this;
    }
}
