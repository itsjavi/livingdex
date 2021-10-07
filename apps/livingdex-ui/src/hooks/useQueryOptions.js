import { useLocation } from "react-router-dom"
import PokemonListOptions from "../app/PokemonListOptions"
import { useMemo } from "react"

/**
 * @returns {PokemonListOptions}
 */
function useQueryOptions(speciesOnlyByDefault = false) {
  const search = useLocation().search
  return useMemo(() => {
    const query = new URLSearchParams(search)
    let currentOpts = new PokemonListOptions()

    currentOpts.gen = query.get("gen")
    currentOpts.search = query.get("q")

    if (speciesOnlyByDefault) {
      currentOpts.showForms = query.has("all")
      currentOpts.showCosmeticForms = query.has("all")
    } else {
      currentOpts.showForms = !query.has("noforms") || query.has("all")
      currentOpts.showCosmeticForms = !query.has("nocosmetic") || query.has("all")
    }

    currentOpts.viewShiny = query.has("shiny")
    currentOpts.onlyHomeStorable = !query.has("all")
    currentOpts.separateBoxPikachu = query.get("sbpika")
    currentOpts.separateBoxForms = query.get("sbforms")

    return currentOpts
  }, [search, speciesOnlyByDefault])
}

export default useQueryOptions