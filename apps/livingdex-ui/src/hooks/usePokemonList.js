import { useEffect, useState } from "react"
import { PokeApi } from "../app/api"

const api = new PokeApi()

/**
 * @param {PokemonListOptions} options
 * @param {PokemonListItem} pkm
 * @returns {boolean}
 */
function shouldSkip(options, pkm) {
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
  if (options.search.length > 2) {
    let reg = new RegExp(options.search, "gi")
    let typeFound = ((pkm.type1 !== null && pkm.type1.match(reg))
      || (pkm.type2 !== null && pkm.type2.match(reg)))

    if (!pkm.name.match(reg) && !pkm.slug.match(reg)) {
      return !typeFound
    }
  }
  return false
}

/**
 * @param {PokemonListOptions} initialOptions
 * @return {{pokemon: PokemonListItemSimple[], options: PokemonListOptions, loading: boolean}}
 */
function usePokemonList(initialOptions) {
  const [options] = useState(initialOptions)
  const [pokemonList, setPokemonList] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    async function fetchPokemonList() {
      setLoading(true)
      api.generation = options.gen

      const response = await api.getPokemonList()
        .then(function(apiResponse) {
          let pokedex = []
          let idx = 0
          // TODO: stop using PokemonListItemSimple, use regular one:
          // let getObj = (pkm) => {
          //   return {
          //     //...pkm,
          //     id: pkm.id,
          //       dexNum: pkm.num,
          //     tabIndex: idx,
          //     // file: pkm.imgHome + ".png",
          //     file: pkm.imgHome + ".png",
          //     fileBaseName: pkm.imgHome.split("/").pop(),
          //     slug: pkm.slug,
          //     name: pkm.name,
          //     isCosmetic: pkm.isCosmetic,
          //     baseSpecies: pkm.baseSpecies,
          //   }
          // }

          for (let slug in apiResponse) {
            let pkm = apiResponse[slug]
            if (shouldSkip(options, pkm)) {
              continue
            }
            pkm.tabIndex = idx
            // if (pkm.baseSpecies !== null) {
            //   continue
            // }
            idx++
            pokedex.push(pkm)
          }

          // for (let slug in apiResponse) {
          //   let pkm = apiResponse[slug]
          //   if (shouldSkip(options, pkm)) {
          //     continue
          //   }
          //   if (pkm.baseSpecies === null) {
          //     continue
          //   }
          //   idx++
          //   pokedex.push(pkm)
          // }

          return pokedex
        })
      setPokemonList(response)
      setLoading(false)
    }

    fetchPokemonList()
  }, [options])

  return { pokemon: pokemonList, loading: loading, options: options }
}

export default usePokemonList
