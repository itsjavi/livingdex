import "./App.css"
import PokedexPage from "../../pages/PokedexPage/PokedexPage"
import { Route, Switch, useLocation } from "react-router-dom"
import BoxesPage from "../../pages/BoxesPage/BoxesPage"
import PokemonDetailsPage from "../../pages/PokemonDetailsPage/PokemonDetailsPage"

function App() {
  const loc = useLocation()
  const locationState = loc.pathname + "@" + loc.hash + "@" + loc.search.toString()

  return (
    <Switch key={locationState}>
      <Route path="/pokedex">
        <PokedexPage />
      </Route>
      <Route path={`/pokemon/:slug`}>
        <PokemonDetailsPage />
      </Route>
      <Route path="/">
        <BoxesPage />
      </Route>
    </Switch>
  )
}

App.propTypes = {}

export default App
