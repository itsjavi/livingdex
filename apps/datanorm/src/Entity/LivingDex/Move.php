<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\IdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Entity\LivingDex\ColumnTrait\SlugColumnTrait;
use App\Repository\LivingDex\MoveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoveRepository::class)
 */
class Move
{
    use IdColumnTrait, GenColumnTrait, SlugColumnTrait, NameColumnTrait;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isZmove;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $showdownName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $veekunName;

    /**
     * @ORM\OneToMany(targetEntity=MoveDataGo::class, mappedBy="move")
     */
    private $datumGo;

    /**
     * @ORM\OneToMany(targetEntity=MoveData::class, mappedBy="move")
     */
    private $datum;

    /**
     * @ORM\OneToMany(targetEntity=MoveText::class, mappedBy="move")
     */
    private $texts;

    public function __construct()
    {
        $this->datumGo = new ArrayCollection();
        $this->datum = new ArrayCollection();
        $this->texts = new ArrayCollection();
    }

    public function getIsZmove(): ?bool
    {
        return $this->isZmove;
    }

    public function setIsZmove(bool $isZmove): self
    {
        $this->isZmove = $isZmove;

        return $this;
    }

    public function getShowdownName(): ?string
    {
        return $this->showdownName;
    }

    public function setShowdownName(?string $showdownName): self
    {
        $this->showdownName = $showdownName;

        return $this;
    }

    public function getVeekunName(): ?string
    {
        return $this->veekunName;
    }

    public function setVeekunName(?string $veekunName): self
    {
        $this->veekunName = $veekunName;

        return $this;
    }

    /**
     * @return Collection|MoveDataGo[]
     */
    public function getDatumGo(): Collection
    {
        return $this->datumGo;
    }

    public function addDataGo(MoveDataGo $dataGo): self
    {
        if (!$this->datumGo->contains($dataGo)) {
            $this->datumGo[] = $dataGo;
            $dataGo->setMove($this);
        }

        return $this;
    }

    /**
     * @return Collection|MoveData[]
     */
    public function getDatum(): Collection
    {
        return $this->datum;
    }

    public function addData(MoveData $data): self
    {
        if (!$this->datum->contains($data)) {
            $this->datum[] = $data;
            $data->setMove($this);
        }

        return $this;
    }

    /**
     * @return Collection|MoveText[]
     */
    public function getTexts(): Collection
    {
        return $this->texts;
    }

    public function addText(MoveText $text): self
    {
        if (!$this->texts->contains($text)) {
            $this->texts[] = $text;
            $text->setMove($this);
        }

        return $this;
    }
}
