<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Repository\LivingDex\PokemonMoveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonMoveRepository::class)
 */
class PokemonMove
{
    use AutoIdColumnTrait, GenColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="moves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pokemon;

    /**
     * @ORM\ManyToOne(targetEntity=Move::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $move;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $learnMethod;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $learnLevel;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSignatureMove;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class)
     */
    private $zCrystalItem;

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getMove(): ?Move
    {
        return $this->move;
    }

    public function setMove(?Move $move): self
    {
        $this->move = $move;

        return $this;
    }

    public function getLearnMethod(): ?string
    {
        return $this->learnMethod;
    }

    public function setLearnMethod(string $learnMethod): self
    {
        $this->learnMethod = $learnMethod;

        return $this;
    }

    public function getLearnLevel(): ?int
    {
        return $this->learnLevel;
    }

    public function setLearnLevel(?int $learnLevel): self
    {
        $this->learnLevel = $learnLevel;

        return $this;
    }

    public function getIsSignatureMove(): ?bool
    {
        return $this->isSignatureMove;
    }

    public function setIsSignatureMove(bool $isSignatureMove): self
    {
        $this->isSignatureMove = $isSignatureMove;

        return $this;
    }

    public function getZCrystalItem(): ?Item
    {
        return $this->zCrystalItem;
    }

    public function setZCrystalItem(?Item $zCrystalItem): self
    {
        $this->zCrystalItem = $zCrystalItem;

        return $this;
    }
}
