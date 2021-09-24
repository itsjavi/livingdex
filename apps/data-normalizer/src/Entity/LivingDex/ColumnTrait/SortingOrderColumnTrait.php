<?php

declare(strict_types=1);

namespace App\Entity\LivingDex\ColumnTrait;

use Doctrine\ORM\Mapping as ORM;

trait SortingOrderColumnTrait
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private ?int $sortingOrder;

    public function getSortingOrder(): ?int
    {
        return $this->sortingOrder;
    }

    public function setSortingOrder(int $sortingOrder): self
    {
        $this->sortingOrder = $sortingOrder;

        return $this;
    }
}
