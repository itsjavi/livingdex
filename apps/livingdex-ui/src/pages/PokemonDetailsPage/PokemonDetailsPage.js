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
  const {pokemon, loading} = usePokemon(q.gen, slug, true)

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

  subtitle = "Pokédex"

  let img = PokeImg(pokemon.slug, pokemon.name, q.viewShiny, 'pkm-2x')

  let baseSpecies = null
  let baseDataForm = null

  if (pokemon.baseSpecies) {
    baseDataForm = [
      <div key={2}><h3>Species</h3></div>,
      <span key={3}>
        <Link className={"mugShot"} to={"/pokemon/" + pokemon.baseSpecies.slug}>
          {PokeImg(pokemon.baseSpecies.slug, pokemon.baseSpecies.name, q.viewShiny)}
        </Link>
        <span className={"mugShotTitle"}>{pokemon.baseSpecies.name}</span>
      </span>,
      <hr key={4}/>
    ]
  }
  //
  let forms = []

  // TODO: add image file to forms array
  if (pokemon.forms.length > 0) {
    forms.push(
      <div key={2}><h3>Other Forms ({pokemon.forms.length})</h3></div>
    )
    // forms.push(
    //   <span key={3} className={"mugShotWrapper currentMugShotWrapper"}>
    //     <Link className={"mugShot currentMugShot"} to={"/pokemon/" + pokemon.slug}>
    //       {PokeImg(pokemon.slug, pokemon.name, q.viewShiny)}
    //     </Link>
    //     <span className={"mugShotTitle"}>{pokemon.formName || pokemon.name}</span>
    //   </span>
    // )
    for (let i in pokemon.forms) {
      let formData = pokemon.forms[i]
      forms.push(
        <span key={3 + i + 1} className={"mugShotWrapper"}>
          <Link className={"mugShot"} to={"/pokemon/" + formData.slug}>
            {PokeImg(formData.slug, formData.name, q.viewShiny)}
          </Link>
          <span className={"mugShotTitle"}>{formData.formName}</span>
      </span>
      )
    }
    forms.push(<hr key={1000}/>)
  }

  // TODO: loadPokemon(props.slug)

  let dataUrl = PokeApiDefaultBaseUrl + `/gen/${q.gen}/pokemon/${pokemon.slug}.json`;

  let pokeTitle = pokemon.name;
  if (pokemon.baseSpecies === null && pokemon.formName !== null && pokemon.formName !== '') {
    pokeTitle += ` (${pokemon.formName})`;
  }

  return (
    <div className="app themePurple bgGradientDown">
      <Layout title={"Living Dex"} subtitle={subtitle}>
        <div className={"pokemonDetailsPage"} style={{textAlign: "center"}}>
          <h2>{pokeTitle}</h2>
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
