import {Layout} from "../../components/Layout/Layout"
import styles from "./PokedexPage.module.css"
import React, {useState} from "react"
import usePokemonList from "../../hooks/usePokemonList"
import useQueryOptions from "../../hooks/useQueryOptions"
import {useHistory} from "react-router-dom"
import {PokeImg} from "../../components/PokeImg/PokeImg"

function PokedexPage() {
  const history = useHistory()
  const q = useQueryOptions(true)
  q.onlyHomeStorable = false
  const [listOptions] = useState(q)
  const {pokemon, loading} = usePokemonList(listOptions)

  let items = []
  let title = <span>Living Dex</span>
  // let title = <span>Pokédex</span>
  let subtitle = "Loading..."

  if (loading === false) {

    const handleClick = (e) => {
      history.push("/pokemon/" + e.currentTarget.dataset.slug)
    }

    let total = 0
    for (const pkm of pokemon) {
      if (pkm.baseSpecies !== null) {
        continue
      }
      total++

      let img = PokeImg(pkm.slug, pkm.name, q.viewShiny)

      let dataAttrs = {
        'data-slug': pkm.slug
      }
      items.push(
        <div title={pkm.name}
             tabIndex={pkm.num}
             key={pkm.id}
             className={styles.pokedexListItem}
             {...dataAttrs}
             onClick={handleClick}>
          {img}
        </div>,
      )
    }
    subtitle = "National Pokédex (" + total + " Species)"
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
