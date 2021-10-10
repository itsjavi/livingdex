import { PokeApiMaxGen } from "./api"

class PokemonListOptions {
  _gen = PokeApiMaxGen
  _search = ""
  showForms = true
  showCosmeticForms = true
  separateBoxPikachu = false
  separateBoxForms = false
  onlyHomeStorable = false
  viewShiny = false
  boxStyle = 'grouped'

  get gen() {
    return this._gen
  }

  set gen(value) {
    this._gen = Math.min(
      PokeApiMaxGen,
      Math.max(1, parseInt(value + "")) || PokeApiMaxGen,
    )
  }

  get search() {
    return this._search
  }

  set search(value) {
    this._search = value === null ? "" : value
  }
}

const defaultPokemonListOptions = new PokemonListOptions()

export default PokemonListOptions
export { defaultPokemonListOptions, PokemonListOptions }
