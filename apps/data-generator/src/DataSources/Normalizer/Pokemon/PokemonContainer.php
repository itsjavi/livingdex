<?php

declare(strict_types=1);

namespace App\DataSources\Normalizer\Pokemon;

use App\Entity\LivingDex\Pokemon;
use App\Entity\LivingDex\PokemonData;
use App\Entity\LivingDex\PokemonDataGo;

class PokemonContainer
{
    private Pokemon $entity;
    private ?PokemonData $data = null;
    private ?PokemonDataGo $dataGo = null;
    private array $showdownData;
    private array $veekunData;

    public function __construct(array $showdownData)
    {
        $this->entity = new Pokemon();
        $this->showdownData = $showdownData;
        $this->veekunData = [];
    }

    public function getEntity(): Pokemon
    {
        return $this->entity;
    }

    public function getId(): ?int
    {
        return $this->entity->getId();
    }

    public function getSlug(): string
    {
        return $this->entity->getSlug();
    }

    public function createData(): PokemonData
    {
        $this->data = new PokemonData();

        return $this->data;
    }

    public function createDataGo(): PokemonDataGo
    {
        $this->dataGo = new PokemonDataGo();

        return $this->dataGo;
    }

    public function getData(): ?PokemonData
    {
        return $this->data;
    }

    public function getDataGo(): ?PokemonDataGo
    {
        return $this->dataGo;
    }

    public function getShowdownData(): array
    {
        return $this->showdownData;
    }

    public function setShowdownData(array $showdownData): self
    {
        $this->showdownData = $showdownData;

        return $this;
    }

    public function getVeekunData(): array
    {
        return $this->veekunData;
    }

    public function setVeekunData(array $veekunData): self
    {
        $this->veekunData = $veekunData;

        return $this;
    }
}
