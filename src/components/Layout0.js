import React from "react"
import PropTypes from "prop-types"
import { useStaticQuery, graphql } from "gatsby"

import Header0 from "./Header0"
import "./Layout0.scss"
import Footer from "./Footer"

const Layout0 = ({ children }) => {
  const data = useStaticQuery(graphql`
      query SiteTitleQuery {
          site {
              siteMetadata {
                  title
              }
          }
      }
  `)

  return (
    <>
      <Header0 siteTitle={data.site.siteMetadata.title}/>
      <main>
        { children }
      </main>
      <Footer />
    </>
  )
}

Layout0.propTypes = {
  children: PropTypes.node.isRequired,
}

export default Layout0
