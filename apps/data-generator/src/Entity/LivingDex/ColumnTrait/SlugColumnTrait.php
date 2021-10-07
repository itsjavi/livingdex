<?php

declare(strict_types=1);

namespace App\Entity\LivingDex\ColumnTrait;

use Doctrine\ORM\Mapping as ORM;

trait SlugColumnTrait
{
    /**
     * @ORM\Column(type="string", length=40, nullable=false, unique=true)
     */
    private ?string $slug;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
