import React from "react"

import Layout0 from "../components/Layout0"
import SEO from "../components/SEO"
import PokeBoxList from "../components/boxes/PokeBoxList"

const IndexPage = () => (
  <Layout0>
    <SEO title="Box Organizer" />
    <div className="container">
      <div className="hero is-light" style={{borderRadius:"20px"}}>
        <div className="hero-body has-text-centered">
          Living Dex is a visual guide for organizing Pokémon HOME boxes.
          <br />
          This page contains a view of all storable Pokémon forms,
          including all gender differences.
          <br />
          The project is still in a very early state, but
          please feel free to send any feedback directly
          <a href="https://github.com/route1rodent" rel="noopener noreferrer" target="_blank"> via Twitter</a>
        </div>
      </div>
    </div>
    <PokeBoxList/>
  </Layout0>
)

export default IndexPage
