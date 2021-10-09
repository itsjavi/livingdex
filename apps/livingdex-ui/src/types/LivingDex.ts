declare module LivingDex {
  // generated with the help of http://json2ts.com/

  export interface BoxPosition {
    box: number;
    col: number;
    row: number;
    debug: string;
  }

  export interface PokemonStats {
    hp: number;
    atk: number;
    def: number;
    spa: number;
    spd: number;
    spe: number;
  }

  export interface PokemonListItemSimple {
    id: number;
    dexNum: number;
    tabIndex: number;
    file: string;
    fileBaseName: string;
    slug: string;
    name: string;
    isCosmetic: string;
    baseSpecies: string | PokemonListItemSimple;
  }

  export interface PokemonListItem {
    id: number;
    num: number;
    slug: string;
    name: string;
    title: string;
    gen: number;
    forms: string[] | PokemonListItem[];
    baseSpecies: string | PokemonListItem;
    formOrder: number;

    isCosmetic: boolean;
    isHomeStorable: boolean;
    isBaseSpecies: boolean;
    isForm: boolean;
    isGmax: boolean;

    type1: string;
    type2: string;
    baseStats: PokemonStats;
  }

  export interface PokemonDetails {
    id: number;
    num: number;
    slug: string;
    name: string;
    gen: number;
    forms: string[] | PokemonDetails[];
    formName: string;
    formSlug: string;
    formOrder: number;
    baseSpecies: string | PokemonDetails;
    //imgSprite: string;
    //imgHome: string;
    dataGen: number;
    type1: string;
    type2?: any;
    eggGroup1: string;
    eggGroup2?: any;
    ability1: string;
    ability2?: any;
    abilityHidden: string;
    height: number;
    weight: number;
    color: string;
    actualColor: string;
    shape: string;
    maleRatio: number;
    femaleRatio: number;
    growthRate: string;
    catchRate: number;
    hatchCycles: number;
    baseFriendship: number;
    baseStats: PokemonStats;
    baseStatsTotal: number;
    yieldStats: PokemonStats;
    yieldBaseExp: number;
    isFemale: boolean;
    isCosmetic: boolean;
    isLegendary: boolean;
    isMythical: boolean;
    isFusion: boolean;
    isMega: boolean;
    isPrimal: boolean;
    isGmax: boolean;
    canDynamax: boolean;
    isTotem: boolean;
    isRegional: boolean;
    isHomeStorable: boolean;
    showdownSlug: string;
    veekunSlug: string;
    veekunFormId: number;

    title: string;
    dexNum: number;
    file: string;
    fileBaseName: string;
  }


}

export {}
