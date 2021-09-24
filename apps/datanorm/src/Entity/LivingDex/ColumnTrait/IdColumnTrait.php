<?php

declare(strict_types=1);

namespace App\Entity\LivingDex\ColumnTrait;

use Doctrine\ORM\Mapping as ORM;

trait IdColumnTrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
