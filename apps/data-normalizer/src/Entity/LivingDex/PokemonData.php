<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Repository\LivingDex\PokemonDataRepository;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @ORM\Entity(repositoryClass=PokemonDataRepository::class)
 */
class PokemonData implements Arrayable
{
    use AutoIdColumnTrait, GenColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="datum")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pokemon;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $type1;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $type2;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $eggGroup1;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $eggGroup2;

    /**
     * @ORM\ManyToOne(targetEntity=Ability::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $ability1;

    /**
     * @ORM\ManyToOne(targetEntity=Ability::class)
     */
    private $ability2;

    /**
     * @ORM\ManyToOne(targetEntity=Ability::class)
     */
    private $abilityHidden;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $actualColor;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $shape;

    /**
     * @ORM\Column(type="integer")
     */
    private $maleRatio;

    /**
     * @ORM\Column(type="integer")
     */
    private $femaleRatio;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $growthRate;

    /**
     * @ORM\Column(type="integer")
     */
    private $catchRate;

    /**
     * @ORM\Column(type="integer")
     */
    private $hatchCycles;

    /**
     * @ORM\Column(type="integer")
     */
    private $baseFriendship;

    /**
     * @ORM\Column(type="integer")
     */
    private $baseHp;

    /**
     * @ORM\Column(type="integer")
     */
    private $baseAttack;

    /**
     * @ORM\Column(type="integer")
     */
    private $baseDefense;

    /**
     * @ORM\Column(type="integer")
     */
    private $baseSpAttack;

    /**
     * @ORM\Column(type="integer")
     */
    private $baseSpDefense;

    /**
     * @ORM\Column(type="integer")
     */
    private $baseSpeed;

    /**
     * @ORM\Column(type="integer")
     */
    private $yieldBaseExp;

    /**
     * @ORM\Column(type="integer")
     */
    private $yieldHp;

    /**
     * @ORM\Column(type="integer")
     */
    private $yieldAttack;

    /**
     * @ORM\Column(type="integer")
     */
    private $yieldDefense;

    /**
     * @ORM\Column(type="integer")
     */
    private $yieldSpAttack;

    /**
     * @ORM\Column(type="integer")
     */
    private $yieldSpDefense;

    /**
     * @ORM\Column(type="integer")
     */
    private $yieldSpeed;

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }

    public function getType1(): ?string
    {
        return $this->type1;
    }

    public function setType1(string $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getEggGroup1(): ?string
    {
        return $this->eggGroup1;
    }

    public function setEggGroup1(string $eggGroup1): self
    {
        $this->eggGroup1 = $eggGroup1;

        return $this;
    }

    public function getEggGroup2(): ?string
    {
        return $this->eggGroup2;
    }

    public function setEggGroup2(?string $eggGroup2): self
    {
        $this->eggGroup2 = $eggGroup2;

        return $this;
    }

    public function getAbility1(): ?Ability
    {
        return $this->ability1;
    }

    public function setAbility1(?Ability $ability1): self
    {
        $this->ability1 = $ability1;

        return $this;
    }

    public function getAbility2(): ?Ability
    {
        return $this->ability2;
    }

    public function setAbility2(?Ability $ability2): self
    {
        $this->ability2 = $ability2;

        return $this;
    }

    public function getAbilityHidden(): ?Ability
    {
        return $this->abilityHidden;
    }

    public function setAbilityHidden(?Ability $abilityHidden): self
    {
        $this->abilityHidden = $abilityHidden;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getActualColor(): ?string
    {
        return $this->actualColor;
    }

    public function setActualColor(?string $actualColor): self
    {
        $this->actualColor = $actualColor;

        return $this;
    }

    public function getShape(): ?string
    {
        return $this->shape;
    }

    public function setShape(?string $shape): self
    {
        $this->shape = $shape;

        return $this;
    }

    public function getMaleRatio(): ?int
    {
        return $this->maleRatio;
    }

    public function setMaleRatio(int $maleRatio): self
    {
        $this->maleRatio = $maleRatio;

        return $this;
    }

    public function getFemaleRatio(): ?int
    {
        return $this->femaleRatio;
    }

    public function setFemaleRatio(int $femaleRatio): self
    {
        $this->femaleRatio = $femaleRatio;

        return $this;
    }

    public function getGrowthRate(): ?string
    {
        return $this->growthRate;
    }

    public function setGrowthRate(string $growthRate): self
    {
        $this->growthRate = $growthRate;

        return $this;
    }

    public function getCatchRate(): ?int
    {
        return $this->catchRate;
    }

    public function setCatchRate(int $catchRate): self
    {
        $this->catchRate = $catchRate;

        return $this;
    }

    public function getHatchCycles(): ?int
    {
        return $this->hatchCycles;
    }

    public function setHatchCycles(?int $hatchCycles): self
    {
        $this->hatchCycles = $hatchCycles;

        return $this;
    }

    public function getBaseFriendship(): ?int
    {
        return $this->baseFriendship;
    }

    public function setBaseFriendship(int $baseFriendship): self
    {
        $this->baseFriendship = $baseFriendship;

        return $this;
    }

    public function getBaseAttack(): ?int
    {
        return $this->baseAttack;
    }

    public function setBaseAttack(int $baseAttack): self
    {
        $this->baseAttack = $baseAttack;

        return $this;
    }

    public function getBaseDefense(): ?int
    {
        return $this->baseDefense;
    }

    public function setBaseDefense(int $baseDefense): self
    {
        $this->baseDefense = $baseDefense;

        return $this;
    }

    public function getBaseSpAttack(): ?int
    {
        return $this->baseSpAttack;
    }

    public function setBaseSpAttack(int $baseSpAttack): self
    {
        $this->baseSpAttack = $baseSpAttack;

        return $this;
    }

    public function getBaseSpDefense(): ?int
    {
        return $this->baseSpDefense;
    }

    public function setBaseSpDefense(int $baseSpDefense): self
    {
        $this->baseSpDefense = $baseSpDefense;

        return $this;
    }

    public function getBaseSpeed(): ?int
    {
        return $this->baseSpeed;
    }

    public function setBaseSpeed(int $baseSpeed): self
    {
        $this->baseSpeed = $baseSpeed;

        return $this;
    }

    public function getYieldBaseExp(): ?int
    {
        return $this->yieldBaseExp;
    }

    public function setYieldBaseExp(int $yieldBaseExp): self
    {
        $this->yieldBaseExp = $yieldBaseExp;

        return $this;
    }

    public function getYieldHp(): ?int
    {
        return $this->yieldHp;
    }

    public function setYieldHp(int $yieldHp): self
    {
        $this->yieldHp = $yieldHp;

        return $this;
    }

    public function getYieldAttack(): ?int
    {
        return $this->yieldAttack;
    }

    public function setYieldAttack(int $yieldAttack): self
    {
        $this->yieldAttack = $yieldAttack;

        return $this;
    }

    public function getYieldDefense(): ?int
    {
        return $this->yieldDefense;
    }

    public function setYieldDefense(int $yieldDefense): self
    {
        $this->yieldDefense = $yieldDefense;

        return $this;
    }

    public function getYieldSpAttack(): ?int
    {
        return $this->yieldSpAttack;
    }

    public function setYieldSpAttack(int $yieldSpAttack): self
    {
        $this->yieldSpAttack = $yieldSpAttack;

        return $this;
    }

    public function getYieldSpDefense(): ?int
    {
        return $this->yieldSpDefense;
    }

    public function setYieldSpDefense(int $yieldSpDefense): self
    {
        $this->yieldSpDefense = $yieldSpDefense;

        return $this;
    }

    public function getYieldSpeed(): ?int
    {
        return $this->yieldSpeed;
    }

    public function setYieldSpeed(int $yieldSpeed): self
    {
        $this->yieldSpeed = $yieldSpeed;

        return $this;
    }

    public function getBaseHp(): ?int
    {
        return $this->baseHp;
    }

    public function setBaseHp(int $baseHp): self
    {
        $this->baseHp = $baseHp;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'dataGen'        => $this->getGen(),
            'type1'          => $this->getType1(),
            'type2'          => $this->getType2(),
            'eggGroup1'      => $this->getEggGroup1(),
            'eggGroup2'      => $this->getEggGroup2(),
            'ability1'       => $this->getAbility1() ? $this->getAbility1()->getSlug() : null,
            'ability2'       => $this->getAbility2() ? $this->getAbility2()->getSlug() : null,
            'abilityHidden'  => $this->getAbilityHidden() ? $this->getAbilityHidden()->getSlug() : null,
            'height'         => $this->getHeight(),
            'weight'         => $this->getWeight(),
            'color'          => $this->getColor(),
            'actualColor'    => $this->getActualColor(),
            'shape'          => $this->getShape(),
            'maleRatio'      => $this->getMaleRatio(),
            'femaleRatio'    => $this->getFemaleRatio(),
            'growthRate'     => $this->getGrowthRate(),
            'catchRate'      => $this->getCatchRate(),
            'hatchCycles'    => $this->getHatchCycles(),
            'baseFriendship' => $this->getBaseFriendship(),
            'baseStats'      => [
                'hp'  => $this->getBaseHp(),
                'atk' => $this->getBaseAttack(),
                'def' => $this->getBaseDefense(),
                'spa' => $this->getBaseSpAttack(),
                'spd' => $this->getBaseSpDefense(),
                'spe' => $this->getBaseSpeed(),
            ],
            'baseStatsTotal' => (
                $this->getBaseHp()
                + $this->getBaseAttack()
                + $this->getBaseDefense()
                + $this->getBaseSpAttack()
                + $this->getBaseSpDefense()
                + $this->getBaseSpeed()
            ),
            'yieldStats'     => [
                'hp'  => $this->getYieldHp(),
                'atk' => $this->getYieldAttack(),
                'def' => $this->getYieldDefense(),
                'spa' => $this->getYieldSpAttack(),
                'spd' => $this->getYieldSpDefense(),
                'spe' => $this->getYieldSpeed(),
            ],
            'yieldBaseExp'   => $this->getYieldBaseExp(),
        ];
    }
}
