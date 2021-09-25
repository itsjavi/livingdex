<?php

declare(strict_types=1);

namespace App\Entity\LivingDex\ColumnTrait;

use Doctrine\ORM\Mapping as ORM;

trait DescriptionColumnTrait
{
    /**
     * @ORM\Column(type="text", length=65536)
     */
    private ?string $description;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
