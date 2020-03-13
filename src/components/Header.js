import { Link } from "gatsby"
import PropTypes from "prop-types"
import React from "react"

const Header = ({ siteMeta }) => (
  <header className="pk-main-header">
    <Link to="#"><h1>{siteMeta.title}</h1><sup><small>{siteMeta.version}</small></sup></Link>
  </header>
)

Header.propTypes = {
  siteMeta: PropTypes.arrayOf(PropTypes.object).isRequired
}

export default Header
