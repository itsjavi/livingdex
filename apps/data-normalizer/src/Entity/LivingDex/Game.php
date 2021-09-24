<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\IdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Entity\LivingDex\ColumnTrait\SlugColumnTrait;
use App\Entity\LivingDex\ColumnTrait\SortingOrderColumnTrait;
use App\Repository\LivingDex\GameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    use IdColumnTrait, GenColumnTrait, SlugColumnTrait, NameColumnTrait, SortingOrderColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=GameGroup::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameGroup;

    public function getGameGroup(): ?GameGroup
    {
        return $this->gameGroup;
    }

    public function setGameGroup(?GameGroup $gameGroup): self
    {
        $this->gameGroup = $gameGroup;

        return $this;
    }
}
