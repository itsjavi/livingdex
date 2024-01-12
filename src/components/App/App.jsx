import "./App.css"
import {Route, Switch, useLocation} from "react-router-dom"
import BoxesPage from "../../pages/BoxesPage/BoxesPage"

function App() {
  const loc = useLocation()
  const locationState = loc.pathname + "@" + loc.hash + "@" + loc.search.toString()

  return (
    <Switch key={locationState}>
      <Route path="/">
        <BoxesPage/>
      </Route>
    </Switch>
  )
}

App.propTypes = {}

export default App
