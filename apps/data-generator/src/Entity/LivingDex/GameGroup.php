<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\IdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Entity\LivingDex\ColumnTrait\SlugColumnTrait;
use App\Entity\LivingDex\ColumnTrait\SortingOrderColumnTrait;
use App\Repository\LivingDex\GameGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameGroupRepository::class)
 */
class GameGroup
{
    use IdColumnTrait, GenColumnTrait, SlugColumnTrait, NameColumnTrait, SortingOrderColumnTrait;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="gameGroup")
     * @ORM\OrderBy({"sortingOrder" = "ASC"})
     */
    private $games;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="date")
     */
    private $releaseDate;

    /**
     * @ORM\ManyToOne(targetEntity=GameGroup::class)
     */
    private $baseGameGroup;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setGameGroup($this);
        }

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getBaseGameGroup(): ?self
    {
        return $this->baseGameGroup;
    }

    public function setBaseGameGroup(?self $baseGameGroup): self
    {
        $this->baseGameGroup = $baseGameGroup;

        return $this;
    }
}
