import React from "react"

import Layout from "../components/layout"
import SEO from "../components/seo"
import PokeBoxList from "../components/boxes/PokeBoxList"

const IndexPage = () => (
  <Layout>
    <SEO title="Home" />
    <PokeBoxList/>
  </Layout>
)

export default IndexPage
