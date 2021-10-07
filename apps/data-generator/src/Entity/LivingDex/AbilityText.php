<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\DescriptionColumnTrait;
use App\Entity\LivingDex\ColumnTrait\DetailedDescriptionColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\LangColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Repository\LivingDex\AbilityTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbilityTextRepository::class)
 */
class AbilityText
{
    use AutoIdColumnTrait,
        GenColumnTrait,
        LangColumnTrait,
        NameColumnTrait,
        DescriptionColumnTrait,
        DetailedDescriptionColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Ability::class, inversedBy="texts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ability;

    public function getAbility(): ?Ability
    {
        return $this->ability;
    }

    public function setAbility(?Ability $ability): self
    {
        $this->ability = $ability;

        return $this;
    }
}
