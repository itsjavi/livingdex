<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\DescriptionColumnTrait;
use App\Entity\LivingDex\ColumnTrait\DetailedDescriptionColumnTrait;
use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\LangColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Repository\LivingDex\ItemTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemTextRepository::class)
 */
class ItemText
{
    use AutoIdColumnTrait,
        GenColumnTrait,
        LangColumnTrait,
        NameColumnTrait,
        DescriptionColumnTrait,
        DetailedDescriptionColumnTrait;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="texts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}
