import {Layout} from "../../components/Layout/Layout"
import styles from "./BoxesPage.module.css"
import React from "react"
import usePokemonList from "../../hooks/usePokemonList"
import useQueryOptions from "../../hooks/useQueryOptions"
import {useHistory} from "react-router-dom"
import {PokeImg} from "../../components/PokeImg/PokeImg"
import groupedBoxes from "../../data/boxes/grouped.json"
import sortedBoxes from "../../data/boxes/sorted.json"

const boxStyles = {
  grouped: groupedBoxes,
  sorted: sortedBoxes
}

const boxStyle = 'grouped'

/**
 * @param {PokemonListItemSimple} pkm
 * @param {History} history
 * @param {boolean} shiny
 */
function createPokemonElement(pkm, history, shiny = false) {
  let img = PokeImg(pkm.slug, pkm.name, shiny, styles["box-img"])

  const handleClick = (e) => {
    history.push("/pokemon/" + e.currentTarget.dataset.slug)
  }

  let dataAttrs = {
    "data-slug": pkm.slug,
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
 * @param boxes
 * @param {PokemonListItemSimple[]} pokemonList
 * @param {History} history
 * @param {boolean} shiny
 */
function createBoxes(boxes, pokemonList, history, shiny = false) {
  let pokemonSlugMap = new Map();
  let pokemonSlugFlagMap = new Map();

  // First, distribute Pokemon list in boxes, rows and cols // TODO have pokemonList as map everywhere
  pokemonList.forEach((pkm, i) => {
    pokemonSlugMap.set(pkm.slug, pkm)
    pokemonSlugFlagMap.set(pkm.slug, false)
  })

  // Second, iterate all boxes, rows and cols to render elements
  let totalLoadedPokemon = 0
  let placeholderCount = 0
  let boxElements = []
  boxes.forEach((box, boxIndex) => {
    let boxPokemon = []
    let boxPokemonFilled = 0
    box.pokemon.forEach((pkmSlug, cellIndex) => {
      if ((pkmSlug !== null) && !pokemonSlugFlagMap.has(pkmSlug)) {
        return
      }
      if (pkmSlug === null) {
        placeholderCount++
        boxPokemon.push(<span key={"placeholder-" + placeholderCount}>&nbsp;</span>)
        return
      }
      totalLoadedPokemon++
      boxPokemonFilled++
      pokemonSlugFlagMap.set(pkmSlug, true)
      boxPokemon.push(createPokemonElement(pokemonSlugMap.get(pkmSlug), history, shiny))
    })

    let boxClassName = styles['box']
    if (boxPokemonFilled === 0) {
      return
      boxClassName += " " + styles['emptyBox']
    }

    boxElements.push(<div key={boxIndex} tabIndex={boxIndex * -1} className={boxClassName}>
      <div className={styles["box-header"]}>
        <div className={styles["box-title"]}>{box.title}</div>
      </div>
      <div className={styles["box-grid"]}>{boxPokemon}</div>
    </div>)
  })

  console.debug("Total shown pokemon:", totalLoadedPokemon)

  pokemonSlugFlagMap.forEach(function (value, key) {
    if (value === false) {
      console.error(`Pokemon ${key} is not present in the boxes json file`)
    }
  })

  return boxElements
}

function BoxesPage() {
  const history = useHistory()
  const q = useQueryOptions()
  const {pokemon, loading} = usePokemonList(q)

  let boxes = null
  let title = <span>Living Dex</span>
  let subtitle = "Loading..."

  if (loading === false) {
    let boxStyleData = boxStyles[q.boxStyle]
    boxes = createBoxes(boxStyleData.boxes, pokemon, history, q.viewShiny)
    subtitle = boxStyleData.description
  }

  console.debug("Total pokemon forms:", pokemon.length)

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
