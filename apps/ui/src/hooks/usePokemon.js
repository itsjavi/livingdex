import { useEffect, useState } from "react"
import { PokeApi } from "../app/api"

const api = new PokeApi()

/**
 * @param {string }slug
 * @returns {Promise<PokemonDetails>}
 */
function fetchPokemon(slug) {
  return api.getPokemon(slug, false)
    .then((resp) => {
      resp.dexNum = resp.num
      resp.file = resp.imgHome + ".png"
      resp.fileBaseName = resp.imgHome.split("/").pop()

      let promise = Promise.resolve(resp)

      if (resp.baseSpecies !== null) {
        promise = promise.then((resolvedResp) => {
          return fetchPokemon(resp.baseSpecies)
            .then((baseDataResp) => {
              resolvedResp.baseSpecies = baseDataResp

              return resolvedResp
            })
        })
      }

      if (resp.baseDataForm !== null) {
        promise = promise.then((resolvedResp) => {
          return fetchPokemon(resp.baseDataForm)
            .then((baseDataResp) => {
              resolvedResp.baseDataForm = baseDataResp

              return resolvedResp
            })
        })
      }

      return promise
    })
}

/**
 * @param {int} gen
 * @param {string} slug
 * @return {{pokemon: PokemonDetails, loading: boolean}}
 */
function usePokemon(gen, slug) {
  const [pokemon, setPokemon] = useState(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    async function fetchPokemonEffect() {
      setLoading(true)
      api.generation = gen

      const response = await fetchPokemon(slug)
      setPokemon(response)
      setLoading(false)
    }

    fetchPokemonEffect()
  }, [gen, slug])

  return { pokemon: pokemon, loading: loading }
}

export default usePokemon