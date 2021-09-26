import { Layout } from "../../components/Layout/Layout"
import styles from "./BoxesPage.module.css"
import { CreateImage, CreateThumbImage } from "../../components/CreateImage"
import React from "react"
import { CalcBoxPosition } from "../../app/utils"
import usePokemonList from "../../hooks/usePokemonList"
import useQueryOptions from "../../hooks/useQueryOptions"
import { useHistory } from "react-router-dom"

/**
 * @param {PokemonListItemSimple} pkm
 * @param {History} history
 * @param {boolean} shiny
 */
function createPokemonElement(pkm, history, shiny = false) {
  let img = CreateThumbImage(
    './assets/images/placeholder.png',
    pkm.name,
    styles["box-img"] + " pkm pkm-" + pkm.fileBaseName + (shiny ? ' shiny': ''),
  )

  const handleClick = (e) => {
    history.push("/pokemon/" + e.currentTarget.dataset.slug)
  }

  let dataAttrs = {
    'data-slug': pkm.slug
  }

  // TODO use same component on all pkm lists
  return <div title={pkm.name}
              tabIndex={pkm.tabIndex}
              key={pkm.id}
              className={styles["box-cell"]}>
    <figure>
      <div className={styles["box-cell-content"]}>
        <span className={styles["box-cell-thumbnail"]}>{img}</span>
        <figcaption
          onClick={handleClick}
          {...dataAttrs}>{pkm.name}</figcaption>
      </div>
    </figure>
  </div>
}

/**
 * @param {PokemonListItemSimple[]} pokemonList
 * @param {History} history
 * @param {boolean} shiny
 */
function createBoxes(pokemonList, history, shiny = false) {
  let boxes = new Map()

  // First, distribute Pokemon list in boxes, rows and cols
  pokemonList.forEach((pkm, i) => {
    let pos = CalcBoxPosition(i, 5, 6)
    if (!boxes.has(pos.box)) {
      boxes.set(pos.box, new Map())
    }
    let box = boxes.get(pos.box)
    if (!box.has(pos.row)) {
      box.set(pos.row, new Map())
    }
    let row = box.get(pos.row)
    row.set(pos.col, pkm)
  })

  // Second, iterate all boxes, rows and cols to render elements
  let boxElements = []
  boxes.forEach((box, boxIndex) => {
    let boxPokemon = []
    box.forEach((row, rowIndex) => {
      row.forEach((pkm, colIndex) => {
        boxPokemon.push(createPokemonElement(pkm, history, shiny))
      })
    })
    boxElements.push(<div key={boxIndex} tabIndex={boxIndex * -1  } className={styles["box"]}>
      <div className={styles["box-header"]}>
        <div className={styles["box-title"]}>{"Box " + (boxIndex + 1)}</div>
      </div>
      <div className={styles["box-grid"]}>{boxPokemon}</div>
    </div>)
  })

  return boxElements
}

function BoxesPage() {
  const history = useHistory()
  const q = useQueryOptions()
  const { pokemon, loading } = usePokemonList(q)

  let boxes = null
  let title = <span>Living Dex</span>
  let subtitle = "Loading..."

  if (loading === false) {
    boxes = createBoxes(pokemon, history, q.viewShiny)
    subtitle = "Box Organization (" + pokemon.length + " Storable Pokémon)"
  }

  return (
    <div className="app themeTeal bgGradientDown">
      <Layout title={title} subtitle={subtitle}>
        <div className={styles["box-group"]}>
          <div className={styles["box-group-content"]}>
            {boxes}
          </div>
        </div>
      </Layout>
    </div>
  )
}

BoxesPage.propTypes = {}

export default BoxesPage
