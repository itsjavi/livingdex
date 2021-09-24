<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Repository\LivingDex\PokemonDataGoRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonDataGoRepository::class)
 */
class PokemonDataGo
{
    use AutoIdColumnTrait;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $revision;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTimeInterface $patchDate;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="datumGo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pokemon;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxCp;

    /**
     * @ORM\Column(type="integer")
     */
    private $stamina;

    /**
     * @ORM\Column(type="integer")
     */
    private $attack;

    /**
     * @ORM\Column(type="integer")
     */
    private $defense;

    public function getRevision(): ?int
    {
        return $this->revision;
    }

    public function setRevision(int $revision): self
    {
        $this->revision = $revision;

        return $this;
    }

    public function getMaxCp(): ?int
    {
        return $this->maxCp;
    }

    public function setMaxCp(int $maxCp): self
    {
        $this->maxCp = $maxCp;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

        return $this;
    }

    public function getStamina(): ?int
    {
        return $this->stamina;
    }

    public function setStamina(int $stamina): self
    {
        $this->stamina = $stamina;

        return $this;
    }

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getPatchDate(): ?DateTimeInterface
    {
        return $this->patchDate;
    }

    public function setPatchDate(DateTimeInterface $patchDate): self
    {
        $this->patchDate = $patchDate;

        return $this;
    }
}
