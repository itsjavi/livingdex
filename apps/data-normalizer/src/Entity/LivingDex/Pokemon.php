<?php

namespace App\Entity\LivingDex;

use App\Entity\LivingDex\ColumnTrait\GenColumnTrait;
use App\Entity\LivingDex\ColumnTrait\IdColumnTrait;
use App\Entity\LivingDex\ColumnTrait\NameColumnTrait;
use App\Entity\LivingDex\ColumnTrait\SlugColumnTrait;
use App\Entity\LivingDex\ColumnTrait\SortingOrderColumnTrait;
use App\Repository\LivingDex\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonRepository::class)
 */
class Pokemon
{
    use IdColumnTrait, GenColumnTrait, NameColumnTrait, SlugColumnTrait, SortingOrderColumnTrait;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $dexNum;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $formSlug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $formName;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class, inversedBy="children")
     */
    private ?Pokemon $baseSpecies = null;

    /**
     * Direct forms (species -> forms)
     *
     * @ORM\OneToMany(targetEntity=Pokemon::class, mappedBy="baseSpecies")
     * @ORM\OrderBy({"sortingOrder" = "ASC"})
     */
    private Collection $children;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $imgHome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $imgSprite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $showdownSlug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $veekunSlug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $veekunFormId;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isLegendary;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isMythical;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isCosmetic;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isFemale;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isMega;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isPrimal;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isRegional;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isTotem;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isFusion;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isGmax;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $canDynamax;

    /**
     * @ORM\OneToMany(targetEntity=PokemonForm::class, mappedBy="basePokemon")
     * @ORM\OrderBy({"sortingOrder" = "ASC"})
     */
    private Collection $forms;

    /**
     * @ORM\OneToMany(targetEntity=PokemonMove::class, mappedBy="pokemon")
     */
    private Collection $moves;

    /**
     * @ORM\OneToMany(targetEntity=PokemonEvolution::class, mappedBy="fromPokemon")
     */
    private Collection $evolutions;

    /**
     * @ORM\OneToMany(targetEntity=PokemonData::class, mappedBy="pokemon")
     * @ORM\OrderBy({"gen" = "ASC"})
     */
    private Collection $datum;

    /**
     * @ORM\OneToMany(targetEntity=PokemonDataGo::class, mappedBy="pokemon")
     * @ORM\OrderBy({"revision" = "ASC"})
     */
    private Collection $datumGo;

    /**
     * @ORM\OneToMany(targetEntity=PokemonItem::class, mappedBy="pokemon")
     */
    private Collection $wildHeldItems;

    /**
     * @ORM\OneToMany(targetEntity=PokemonGame::class, mappedBy="pokemon")
     */
    private Collection $gameAppearances;

    /**
     * @ORM\OneToMany(targetEntity=PokemonText::class, mappedBy="pokemon")
     */
    private Collection $texts;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isHomeStorable;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class)
     */
    private ?Pokemon $baseDataForm = null;

    public function __construct()
    {
        $this->forms = new ArrayCollection();
        $this->moves = new ArrayCollection();
        $this->evolutions = new ArrayCollection();
        $this->datum = new ArrayCollection();
        $this->wildHeldItems = new ArrayCollection();
        $this->datumGo = new ArrayCollection();
        $this->gameAppearances = new ArrayCollection();
        $this->texts = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDexNum(): ?int
    {
        return $this->dexNum;
    }

    public function setDexNum(int $dexNum): self
    {
        $this->dexNum = $dexNum;

        return $this;
    }

    public function getFormSlug(): ?string
    {
        return $this->formSlug;
    }

    public function setFormSlug(?string $formSlug): self
    {
        $this->formSlug = $formSlug;

        return $this;
    }

    public function getFormName(): ?string
    {
        return $this->formName;
    }

    public function setFormName(?string $formName): self
    {
        $this->formName = $formName;

        return $this;
    }

    public function getBaseSpecies(): ?self
    {
        return $this->baseSpecies;
    }

    public function setBaseSpecies(?self $baseSpecies): self
    {
        $this->baseSpecies = $baseSpecies;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function getImgHome(): ?string
    {
        return $this->imgHome;
    }

    public function setImgHome(string $imgHome): self
    {
        $this->imgHome = $imgHome;

        return $this;
    }

    public function getImgSprite(): ?string
    {
        return $this->imgSprite;
    }

    public function setImgSprite(string $imgSprite): self
    {
        $this->imgSprite = $imgSprite;

        return $this;
    }

    public function getShowdownSlug(): ?string
    {
        return $this->showdownSlug;
    }

    public function setShowdownSlug(?string $showdownSlug): self
    {
        $this->showdownSlug = $showdownSlug;

        return $this;
    }

    public function getVeekunSlug(): ?string
    {
        return $this->veekunSlug;
    }

    public function setVeekunSlug(?string $veekunSlug): self
    {
        $this->veekunSlug = $veekunSlug;

        return $this;
    }

    public function getVeekunFormId(): ?int
    {
        return $this->veekunFormId;
    }

    public function setVeekunFormId(?int $veekunFormId): self
    {
        $this->veekunFormId = $veekunFormId;

        return $this;
    }


    /**
     * @return Collection|PokemonForm[]
     */
    public function getForms(): Collection
    {
        return $this->forms;
    }

    public function addForm(PokemonForm $pokemonForm): self
    {
        if (!$this->forms->contains($pokemonForm)) {
            $this->forms[] = $pokemonForm;
            $pokemonForm->setBasePokemon($this);
        }

        return $this;
    }

    /**
     * @return Collection|PokemonMove[]
     */
    public function getMoves(): Collection
    {
        return $this->moves;
    }

    public function addMove(PokemonMove $move): self
    {
        if (!$this->moves->contains($move)) {
            $this->moves[] = $move;
            $move->setPokemon($this);
        }

        return $this;
    }

    /**
     * @return Collection|PokemonEvolution[]
     */
    public function getEvolutions(): Collection
    {
        return $this->evolutions;
    }

    public function addEvolution(PokemonEvolution $pokemonEvolution): self
    {
        if (!$this->evolutions->contains($pokemonEvolution)) {
            $this->evolutions[] = $pokemonEvolution;
            $pokemonEvolution->setFromPokemon($this);
        }

        return $this;
    }

    /**
     * @return Collection|PokemonData[]
     */
    public function getDatum(): Collection
    {
        return $this->datum;
    }

    public function addData(PokemonData $data): self
    {
        if (!$this->datum->contains($data)) {
            $this->datum[] = $data;
            $data->setPokemon($this);
        }

        return $this;
    }

    /**
     * @return Collection|PokemonDataGo[]
     */
    public function getDatumGo(): Collection
    {
        return $this->datumGo;
    }

    public function addDataGo(PokemonDataGo $dataGo): self
    {
        if (!$this->datumGo->contains($dataGo)) {
            $this->datumGo[] = $dataGo;
            $dataGo->setPokemon($this);
        }

        return $this;
    }

    /**
     * @return Collection|PokemonItem[]
     */
    public function getWildHeldItems(): Collection
    {
        return $this->wildHeldItems;
    }

    public function addWildHeldItem(PokemonItem $wildHeldItem): self
    {
        if (!$this->wildHeldItems->contains($wildHeldItem)) {
            $this->wildHeldItems[] = $wildHeldItem;
            $wildHeldItem->setPokemon($this);
        }

        return $this;
    }

    /**
     * @return Collection|PokemonGame[]
     */
    public function getGameAppearances(): Collection
    {
        return $this->gameAppearances;
    }

    public function addGetGame(PokemonGame $getGame): self
    {
        if (!$this->gameAppearances->contains($getGame)) {
            $this->gameAppearances[] = $getGame;
            $getGame->setPokemon($this);
        }

        return $this;
    }

    /**
     * @return Collection|PokemonText[]
     */
    public function getTexts(): Collection
    {
        return $this->texts;
    }

    public function addText(PokemonText $text): self
    {
        if (!$this->texts->contains($text)) {
            $this->texts[] = $text;
            $text->setPokemon($this);
        }

        return $this;
    }

    public function isLegendary(): ?bool
    {
        return $this->isLegendary;
    }

    public function setIsLegendary(?bool $isLegendary): self
    {
        $this->isLegendary = $isLegendary;

        return $this;
    }

    public function isMythical(): ?bool
    {
        return $this->isMythical;
    }

    public function setIsMythical(?bool $isMythical): self
    {
        $this->isMythical = $isMythical;

        return $this;
    }

    public function isCosmetic(): ?bool
    {
        return $this->isCosmetic;
    }

    public function setIsCosmetic(?bool $isCosmetic): self
    {
        $this->isCosmetic = $isCosmetic;

        return $this;
    }

    public function isFemale(): ?bool
    {
        return $this->isFemale;
    }

    public function setIsFemale(?bool $isFemale): self
    {
        $this->isFemale = $isFemale;

        return $this;
    }

    public function isMega(): ?bool
    {
        return $this->isMega;
    }

    public function setIsMega(?bool $isMega): self
    {
        $this->isMega = $isMega;

        return $this;
    }

    public function isPrimal(): ?bool
    {
        return $this->isPrimal;
    }

    public function setIsPrimal(?bool $isPrimal): self
    {
        $this->isPrimal = $isPrimal;

        return $this;
    }

    public function isRegional(): ?bool
    {
        return $this->isRegional;
    }

    public function setIsRegional(?bool $isRegional): self
    {
        $this->isRegional = $isRegional;

        return $this;
    }

    public function isTotem(): ?bool
    {
        return $this->isTotem;
    }

    public function setIsTotem(?bool $isTotem): self
    {
        $this->isTotem = $isTotem;

        return $this;
    }

    public function isFusion(): ?bool
    {
        return $this->isFusion;
    }

    public function setIsFusion(?bool $isFusion): self
    {
        $this->isFusion = $isFusion;

        return $this;
    }

    public function isGmax(): ?bool
    {
        return $this->isGmax;
    }

    public function setIsGmax(?bool $isGmax): self
    {
        $this->isGmax = $isGmax;

        return $this;
    }

    public function canDynamax(): ?bool
    {
        return $this->canDynamax;
    }

    public function setCanDynamax(?bool $canDynamax): self
    {
        $this->canDynamax = $canDynamax;

        return $this;
    }

    public function isHomeStorable(): ?bool
    {
        return $this->isHomeStorable;
    }

    public function setIsHomeStorable(bool $isHomeStorable): self
    {
        $this->isHomeStorable = $isHomeStorable;

        return $this;
    }

    public function getBaseDataForm(): ?self
    {
        return $this->baseDataForm;
    }

    public function setBaseDataForm(?self $baseDataForm): self
    {
        $this->baseDataForm = $baseDataForm;

        return $this;
    }
}
