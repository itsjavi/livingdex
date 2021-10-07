<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\AutoIdColumnTrait;
use App\Repository\LivingDex\MoveDataGoRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoveDataGoRepository::class)
 */
class MoveDataGo
{
    use AutoIdColumnTrait;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $revision;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTimeInterface $patchDate;

    /**
     * @ORM\ManyToOne(targetEntity=Move::class, inversedBy="datumGo")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Move $move;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $power;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $energy;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $duration;

    /**
     * DPT
     * @ORM\Column(type="integer")
     */
    private ?int $damagePerTurn;

    /**
     * EPT
     * @ORM\Column(type="integer")
     */
    private ?int $energyPerTurn;

    /**
     * DPE
     * @ORM\Column(type="integer")
     */
    private ?int $damagePerEnergy;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isFast;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isCharged;

    public function getRevision(): ?int
    {
        return $this->revision;
    }

    public function setRevision(int $revision): self
    {
        $this->revision = $revision;

        return $this;
    }

    public function getMove(): ?Move
    {
        return $this->move;
    }

    public function setMove(?Move $move): self
    {
        $this->move = $move;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getEnergy(): ?int
    {
        return $this->energy;
    }

    public function setEnergy(int $energy): self
    {
        $this->energy = $energy;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDamagePerTurn(): ?int
    {
        return $this->damagePerTurn;
    }

    public function setDamagePerTurn(int $damagePerTurn): self
    {
        $this->damagePerTurn = $damagePerTurn;

        return $this;
    }

    public function getEnergyPerTurn(): ?int
    {
        return $this->energyPerTurn;
    }

    public function setEnergyPerTurn(int $energyPerTurn): self
    {
        $this->energyPerTurn = $energyPerTurn;

        return $this;
    }

    public function getDamagePerEnergy(): ?int
    {
        return $this->damagePerEnergy;
    }

    public function setDamagePerEnergy(int $damagePerEnergy): self
    {
        $this->damagePerEnergy = $damagePerEnergy;

        return $this;
    }

    public function getIsFast(): ?bool
    {
        return $this->isFast;
    }

    public function setIsFast(bool $isFast): self
    {
        $this->isFast = $isFast;

        return $this;
    }

    public function getIsCharged(): ?bool
    {
        return $this->isCharged;
    }

    public function setIsCharged(bool $isCharged): self
    {
        $this->isCharged = $isCharged;

        return $this;
    }

    public function getPatchDate(): ?DateTimeInterface
    {
        return $this->patchDate;
    }

    public function setPatchDate(DateTimeInterface $patchDate): self
    {
        $this->patchDate = $patchDate;

        return $this;
    }
}
