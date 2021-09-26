import React from "react"
import styles from "./PokemonDetailsPage.module.css"
import { Layout } from "../../components/Layout/Layout"
import { Link, useParams } from "react-router-dom"
import useQueryOptions from "../../hooks/useQueryOptions"
import usePokemon from "../../hooks/usePokemon"
import { BaseHomeRenderPath, CreateImage, CreateThumbImage } from "../../components/CreateImage"

function PokemonDetailsPage() {
  let { slug } = useParams()
  const q = useQueryOptions()
  const { pokemon, loading } = usePokemon(q.gen, slug)

  let subtitle = "Loading..."

  if (loading) {
    return <div className="app themeTeal bgGradientDown">
      <Layout title={"Living Dex"} subtitle={subtitle}>
        <div className={styles.pokemonDetailsPage}>
          ---
        </div>
      </Layout>
    </div>
  }

  subtitle = pokemon.title

  let img = CreateImage(
    './assets/images/placeholder.png',
    pokemon.name,
    "pkm pkm-" + pokemon.fileBaseName + (q.viewShiny ? ' shiny': ''),
  )

  let baseSpecies = null
  let baseDataForm = null

  if (pokemon.baseSpecies) {
    baseDataForm = <span>
        <Link to={"/pokemon/" + pokemon.baseSpecies.slug}>
          {CreateImage(
            './assets/images/placeholder.png',
            pokemon.name,
            "pkm pkm-" + pokemon.baseSpecies.fileBaseName + (q.viewShiny ? ' shiny': ''),
            pokemon.baseSpecies.title,
          )}
        </Link>
        <span>{" // "}</span>
      </span>
  }

  if (pokemon.baseDataForm) {
    baseDataForm = <span>
        <Link to={"/pokemon/" + pokemon.baseDataForm.slug}>
          {CreateImage(
            BaseHomeRenderPath + "/regular/" + pokemon.baseDataForm.file,
            pokemon.baseDataForm.title,
          )}
        </Link>
        <span>{" // "}</span>
      </span>
  }
  //
  // let forms = [
  //   <p><b>Forms:</b></p>
  // ]
  // TODO: add image file to forms array
  // if (pokemon.forms.length > 0) {
  //   for (let i in pokemon.forms ){
  //     let formSlug = pokemon.forms[i]
  //     forms.push(
  //       <span>
  //       <Link to={"/pokemon/" + formSlug}>
  //         {CreateImage(
  //           BaseHomeRenderPath + "/regular/" + CalcImageSrc(),
  //           pokemon.baseDataForm.title,
  //         )}
  //       </Link>
  //       <span>{" // "}</span>
  //     </span>
  //     )
  //   }
  // }

  // TODO: loadPokemon(props.slug)
  console.log(pokemon)

  return (
    <div className="app themeTeal bgGradientDown">
      <Layout title={"Living Dex"} subtitle={subtitle}>
        <div className={styles.pokemonDetailsPage}>
          {baseSpecies}
          {baseDataForm}
          {img}
          <p><i>This page is still work in progress.</i>  <br /><br /><b>Data:</b></p>
          <pre>{JSON.stringify(pokemon, null, 2)}</pre>
        </div>
      </Layout>
    </div>
  )
}

export default PokemonDetailsPage
export { PokemonDetailsPage }
