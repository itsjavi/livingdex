import "./App.css"
import PokedexPage from "../../pages/PokedexPage/PokedexPage"
import { BrowserRouter as Router, Route, Switch } from "react-router-dom"
import BoxesPage from "../../pages/BoxesPage/BoxesPage"

function App() {

  return (
    <Router basename="/livingdex">
      <Switch>
        <Route path="/pokedex">
          <PokedexPage />
        </Route>
        <Route path="/">
          <BoxesPage />
        </Route>
      </Switch>
    </Router>
  )
}

App.propTypes = {}

export default App
