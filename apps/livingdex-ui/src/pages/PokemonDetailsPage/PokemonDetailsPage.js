import React from "react"
import "./PokemonDetailsPage.css"
import {Layout} from "../../components/Layout/Layout"
import {Link, useParams} from "react-router-dom"
import useQueryOptions from "../../hooks/useQueryOptions"
import usePokemon from "../../hooks/usePokemon"
import {PokeImg} from "../../components/PokeImg/PokeImg"
import {Button} from "../../components/Button/Button";
import {PokeApiDefaultBaseUrl} from "../../app/api";

function PokemonDetailsPage() {
  let {slug} = useParams()
  const q = useQueryOptions()
  const {pokemon, loading} = usePokemon(q.gen, slug)

  let subtitle = "Loading..."

  if (loading) {
    return <div className="app themeTeal bgGradientDown">
      <Layout title={"Living Dex"} subtitle={subtitle}>
        <div className="pokemonDetailsPage">
          ---
        </div>
      </Layout>
    </div>
  }

  subtitle = pokemon.name

  let img = PokeImg(pokemon.slug, pokemon.name, q.viewShiny, 'pkm-2x')

  let baseSpecies = null
  let baseDataForm = null

  if (pokemon.baseSpecies) {
    baseDataForm = [
      <hr/>,
      <p><b>Default Form:</b></p>,
      <span>
        <Link className={"mugShot"} to={"/pokemon/" + pokemon.baseSpecies.slug}>
          {PokeImg(pokemon.baseSpecies.slug, pokemon.baseSpecies.name, q.viewShiny)}
        </Link>
      </span>,
      <hr/>
    ]
  }
  //
  let forms = []

  // TODO: add image file to forms array
  if (pokemon.forms.length > 0) {
    forms.push(
      <hr/>,
      <h3>Forms ({pokemon.forms.length + 1}):</h3>
    )
    forms.push(
      <span>
        <Link className={"mugShot currentMugShot"} to={"/pokemon/" + pokemon.slug}>
          {PokeImg(pokemon.slug, pokemon.name, q.viewShiny)}
        </Link>
      </span>
    )
    for (let i in pokemon.forms) {
      let formSlug = pokemon.forms[i]
      forms.push(
        <span>
        <Link className={"mugShot"} to={"/pokemon/" + formSlug}>
          {PokeImg(formSlug, formSlug, q.viewShiny)}
        </Link>
      </span>
      )
    }
    forms.push(<hr/>)
  }

  // TODO: loadPokemon(props.slug)

  let dataUrl = PokeApiDefaultBaseUrl + `/gen/${q.gen}/pokemon/${pokemon.slug}.json`;

  return (
    <div className="app themePurple bgGradientDown">
      <Layout title={"Living Dex"} subtitle={"Pokédex"}>
        <div className={"pokemonDetailsPage"} style={{textAlign: "center"}}>
          <h2>{pokemon.name}</h2>
          <div className={"pokemonCardWrapper"}>
            <div className={"pokemonCard"}>
              {img}
            </div>
          </div>
          <Button href={dataUrl}>View Data</Button>
          {baseSpecies}
          {baseDataForm}
          {forms}
          <p className={"infoBox"}>
           This page is still a work in progress.
          </p>
          {/*<br/><br/><b>Data:</b>*/}
          {/*<pre>{JSON.stringify(pokemon, null, 2)}</pre>*/}
        </div>
      </Layout>
    </div>
  )
}

export default PokemonDetailsPage
export {PokemonDetailsPage}
