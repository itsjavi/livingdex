import React from "react"

import Layout from "../components/Layout"
import SEO from "../components/SEO"
import PokeBoxList from "../components/boxes/PokeBoxList"

const IndexPage = () => (
  <Layout>
    <SEO title="Pokémon HOME Box Organizer"/>
    <div className="container">
      <div className="hero is-light" style={{
        borderRadius: "20px",
        background: "linear-gradient(180deg, rgba(245,245,245,0.6) 0%, #f5f5f5 100%)",
      }}>
        <div className="hero-body">
          <div className="content  has-text-centered is-medium">
            Living Dex is a visual guide for organizing Pokémon HOME boxes.
            <br/>
            This page contains a view of all storable Pokémon forms,
            including all gender differences.
            <br/>
            The project is still in a very early state, but
            please feel free to send any feedback directly&nbsp;
            <a href="https://github.com/itsjavi/livingdex" rel="noopener noreferrer" target="_blank">
              via Github.
            </a>
          </div>
        </div>
      </div>
    </div>
    <PokeBoxList/>
  </Layout>
)

export default IndexPage
