import { useEffect, useState } from "react"
import { PokeApi, PokeApiMaxGen } from "../app/api"

/**
 * @param {PokemonListOptions} options
 * @return {PokemonListItemSimple[]}
 */
function usePokemonList(options) {
  const api = new PokeApi()

  api.generation = Math.min(
    PokeApiMaxGen,
    Math.max(1, parseInt(options.gen + "")) || PokeApiMaxGen,
  )

  const [pokemonList, setPokemonList] = useState([])

  useEffect(() => {
    getPokemonListAsync()
  }, [])

  function shouldSkip(pkm) {
    if (options.search !== null && options.search.length > 2) {
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

  const getPokemonListAsync = async () => {
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
            file: pkm.imgHome + ".png",
            slug: pkm.slug,
            name: pkm.title,
          })
        }
        return pokedex
      })
    setPokemonList(response)
  }

  return pokemonList
}

export default usePokemonList