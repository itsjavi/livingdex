import { useLocation } from "react-router-dom"
import PokemonListOptions from "../app/PokemonListOptions"

function useQueryOptions() {
  const query = new URLSearchParams(useLocation().search)
  let opts = new PokemonListOptions()

  opts.gen = query.get("gen")
  opts.search = query.get("q")
  opts.onlyHomeStorable = !query.has("all")
  opts.showForms = !query.has("noforms") || query.has("all")
  opts.showCosmeticForms = !query.has("nocosmetic") || query.has("all")
  opts.separateBoxPikachu = query.get("sbpika")
  opts.separateBoxForms = query.get("sbforms")

  return opts
}

export default useQueryOptions