<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Repository\LivingDex\PokemonGameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonGameRepository::class)
 */
class PokemonGame
{
    use AutoIdColumnTrait, GenColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="gameAppearances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pokemon;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * It means if it can be transferred to this game.
     * e.g. Doduo cannot be transferred to Sw/Sh so this will be false for it.
     *
     * @ORM\Column(type="boolean")
     */
    private $isReleased;

    /**
     * If it can be obtained only by in-game methods and anything external.
     *
     * @ORM\Column(type="boolean")
     */
    private $isObtainableInGame;

    /**
     * This could be: wild, sos-battle, max-raid, gift, npc-trade, evolve, ...
     *
     * @ORM\Column(type="string", length=40)
     */
    private $encounterType;

    /**
     * Only obtainable via Mystery Gift or in special events.
     *
     * @ORM\Column(type="boolean")
     */
    private $isEventOnly;

    /**
     * Only can be obtained when transferred from other games.
     *
     * @ORM\Column(type="boolean")
     */
    private $isTransferOnly;

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getIsObtainableInGame(): ?bool
    {
        return $this->isObtainableInGame;
    }

    public function setIsObtainableInGame(bool $isObtainableInGame): self
    {
        $this->isObtainableInGame = $isObtainableInGame;

        return $this;
    }

    public function getIsEventOnly(): ?bool
    {
        return $this->isEventOnly;
    }

    public function setIsEventOnly(bool $isEventOnly): self
    {
        $this->isEventOnly = $isEventOnly;

        return $this;
    }

    public function getIsTransferOnly(): ?bool
    {
        return $this->isTransferOnly;
    }

    public function setIsTransferOnly(bool $isTransferOnly): self
    {
        $this->isTransferOnly = $isTransferOnly;

        return $this;
    }

    public function getIsReleased(): ?bool
    {
        return $this->isReleased;
    }

    public function setIsReleased(bool $isReleased): self
    {
        $this->isReleased = $isReleased;

        return $this;
    }

    public function getEncounterType(): ?string
    {
        return $this->encounterType;
    }

    public function setEncounterType(string $encounterType): self
    {
        $this->encounterType = $encounterType;

        return $this;
    }
}
