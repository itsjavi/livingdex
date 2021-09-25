<?php

declare(strict_types=1);

namespace App\Entity\LivingDex\ColumnTrait;

use Doctrine\ORM\Mapping as ORM;

trait AutoIdColumnTrait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
