<?php

declare(strict_types=1);

namespace App\Entity\LivingDex\ColumnTrait;

use Doctrine\ORM\Mapping as ORM;

trait GenColumnTrait
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private ?int $gen;

    public function getGen(): ?int
    {
        return $this->gen;
    }

    public function setGen(int $gen): self
    {
        $this->gen = $gen;

        return $this;
    }
}
