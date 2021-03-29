declare module LivingDex {
  // generated with the help of http://json2ts.com/

  export interface PokemonListOptions {
    search: string;
    gen: number;
    onlyHomeStorable: boolean;
    showForms: boolean;
    showCosmeticForms: boolean;
    separateBoxPikachu: boolean;
    separateBoxForms: boolean;
  }

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
    slug: string;
    name: string;
  }

  export interface PokemonListItem {
    id: number;
    num: number;
    slug: string;
    name: string;
    title: string;
    gen: number;
    forms: string[];
    imgSprite: string;
    imgHome: string;
    baseSpecies: string;
    baseDataForm: string;
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

}

export {}
