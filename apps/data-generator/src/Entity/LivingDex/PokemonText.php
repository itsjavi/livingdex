<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\DescriptionColumnTrait;
use App\Entity\LivingDex\ColumnTrait\DetailedDescriptionColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\LangColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Repository\LivingDex\PokemonTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonTextRepository::class)
 */
class PokemonText
{
    use AutoIdColumnTrait,
        GenColumnTrait,
        LangColumnTrait,
        NameColumnTrait,
        DescriptionColumnTrait,
        DetailedDescriptionColumnTrait;

    /**
     * aka. Genus
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $classification;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="texts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pokemon;

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getClassification(): ?string
    {
        return $this->classification;
    }

    public function setClassification(?string $classification): self
    {
        $this->classification = $classification;

        return $this;
    }
}
