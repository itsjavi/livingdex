import { Layout } from "../../components/Layout/Layout"
import styles from "./PokedexPage.module.css"
import { BaseHomeRenderPath, Image } from "../../components/Image"
import React from "react"
import usePokemonList from "../../hooks/usePokemonList"
import { useLocation } from "react-router-dom"

function PokedexPage() {
  let query = new URLSearchParams(useLocation().search)
  let opts = {
    "gen": query.get("gen"),
    "search": query.get("q"),
    "showForms": false,
    "showCosmeticForms": false,
    "onlyHomeStorable": true,
  }
  if (query.has("all")) {
    opts.showForms = true
    opts.showCosmeticForms = true
    opts.onlyHomeStorable = true
  }

  const pokemonList = usePokemonList(opts)

  let title = "Living Dex"
  let subtitle = "National Pokédex (" + pokemonList.length + " Pokémon)"

  let pokemonListContainers = []

  for (const pkm of pokemonList) {
    pokemonListContainers.push(
      <div title={pkm.name}
           tabIndex={pkm.num}
           key={pkm.num}
           className={styles.pokedexListItem}>
        <Image src={BaseHomeRenderPath + pkm.file} alt={pkm.name} />
      </div>,
    )
  }

  // let footer = <Panel header={"Panel Header"}>
  //   Panel Body
  // </Panel>
  // let footerActions = <div>
  //   <Button icon={"Y"} type={"shoulderLeft"}>Help</Button>
  //   <Button icon={"B"}>Back</Button>
  // </div>

  return (
    <div className="app themePurple bgGradientDown">
      <Layout title={title} subtitle={subtitle}>
        <div className={styles.pokedexList}>
          {pokemonListContainers}
        </div>
      </Layout>
    </div>
  )
}

PokedexPage.propTypes = {}

export default PokedexPage
