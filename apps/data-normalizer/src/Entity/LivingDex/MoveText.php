<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\DescriptionColumnTrait;
use App\Entity\LivingDex\ColumnTrait\DetailedDescriptionColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\LangColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Repository\LivingDex\MoveTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoveTextRepository::class)
 */
class MoveText
{
    use AutoIdColumnTrait,
        GenColumnTrait,
        LangColumnTrait,
        NameColumnTrait,
        DescriptionColumnTrait,
        DetailedDescriptionColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Move::class, inversedBy="texts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $move;

    public function getMove(): ?Move
    {
        return $this->move;
    }

    public function setMove(?Move $move): self
    {
        $this->move = $move;

        return $this;
    }
}
