<?php

declare(strict_types=1);

namespace App\Entity\LivingDex\ColumnTrait;

use Doctrine\ORM\Mapping as ORM;

trait DetailedDescriptionColumnTrait
{
    /**
     * @ORM\Column(type="text", length=65536, nullable=true)
     */
    private ?string $gameDescription;

    public function getGameDescription(): ?string
    {
        return $this->gameDescription;
    }

    public function setGameDescription(string $gameDescription): self
    {
        $this->gameDescription = $gameDescription;

        return $this;
    }
}
