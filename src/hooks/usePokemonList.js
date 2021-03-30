import { useEffect, useState } from "react"
import { PokeApi } from "../app/api"
import PokemonListOptions, { defaultPokemonListOptions } from "../app/PokemonListOptions"

const api = new PokeApi()

/**
 * @param {PokemonListOptions} options
 * @return {{pokemon: PokemonListItemSimple[], options: PokemonListOptions, loading: boolean}}
 */
function usePokemonList(options) {
  const [pokemonList, setPokemonList] = useState([])
  const [loading, setLoading] = useState(true)

  function shouldSkip(pkm) {
    if (options.search.length > 2) {
      let reg = new RegExp(options.search, "gi")
      if (!pkm.name.match(reg) && !pkm.slug.match(reg)) {
        return true
      }
    }
    if (options.onlyHomeStorable && !pkm.isHomeStorable) {
      return true
    }
    if (options.onlyHomeStorable && pkm.isGmax) {
      return true
    }
    if ((!options.showForms) && pkm.isForm) {
      return true
    }
    if ((!options.showCosmeticForms) && pkm.isCosmetic) {
      return true
    }
    return false
  }

  useEffect(() => {
    async function fetchPokemonList() {
      setLoading(true)
      api.generation = options.gen

      const response = await api.getPokemonList()
        .then(function(apiResponse) {
          let pokedex = []
          let idx = 0
          for (let slug in apiResponse) {
            let pkm = apiResponse[slug]
            if (shouldSkip(pkm)) {
              continue
            }
            idx++
            pokedex.push({
              id: pkm.id,
              dexNum: pkm.num,
              tabIndex: idx,
              // file: pkm.imgHome + ".png",
              file: pkm.imgHome + ".png",
              fileBaseName: pkm.imgHome.split('/').pop(),
              slug: pkm.slug,
              name: pkm.title,
            })
          }
          return pokedex
        })
      setPokemonList(response)
      setLoading(false)
    }

    fetchPokemonList()
  }, [])

  return { pokemon: pokemonList, loading: loading, options: options }
}

export default usePokemonList