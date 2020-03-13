import { Link } from "gatsby"
import PropTypes from "prop-types"
import React from "react"

const Header0 = ({ siteTitle }) => (
  <header className="pk-main-header">
    <Link to="/"><h1>{siteTitle}</h1><sup><small>0.2.0-beta</small></sup></Link>
  </header>
)

Header0.propTypes = {
  siteTitle: PropTypes.string,
}

Header0.defaultProps = {
  siteTitle: ``,
}

export default Header0
