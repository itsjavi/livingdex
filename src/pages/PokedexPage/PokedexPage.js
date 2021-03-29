import { Layout } from "../../components/Layout/Layout"
import styles from "./PokedexPage.module.css"
import { BaseHomeRenderPath, Image } from "../../components/Image"
import React, { useState } from "react"
import usePokemonList from "../../hooks/usePokemonList"
import useQueryOptions from "../../hooks/useQueryOptions"

function PokedexPage() {
  const [listOptions, setListOptions] = useState(useQueryOptions())
  const { pokemon, loading } = usePokemonList(listOptions)

  let items = []
  let title = <span>Living Dex</span>
  // let title = <span>Pokédex</span>
  let subtitle = "Loading..."

  if (loading === false) {
    for (const pkm of pokemon) {
      items.push(
        <div title={pkm.name}
             tabIndex={pkm.num}
             key={pkm.id}
             className={styles.pokedexListItem}>
          <Image src={BaseHomeRenderPath + pkm.file} alt={pkm.name} />
        </div>,
      )
    }
    subtitle = "National Pokédex (" + pokemon.length + " Pokémon)"
  }

  return (
    <div className="app themePurple bgGradientDown">
      <Layout title={title} subtitle={subtitle}>
        <div className={styles.pokedexList}>
          {items}
        </div>
      </Layout>
    </div>
  )
}

PokedexPage.propTypes = {}

export default PokedexPage
