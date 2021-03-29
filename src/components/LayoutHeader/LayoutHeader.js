import React from "react"
import styles from "./LayoutHeader.module.css"
import imgSrc from "./box-icon.svg"
import PropTypes from "prop-types"
import { Link, NavLink } from "react-router-dom"

function LayoutHeader(props) {
  const checkActive = (match, location) => {
    //some additional logic to verify you are in the home URI
    if (!location) {
      return false
    }
    const { pathname } = location
    return pathname === "/"
  }

  return (
    <div className={styles.layoutHeader}>
      <div className={styles.layoutHeaderTop + " bgGradientLeft"}>
        <Link to="/" className={styles.layoutHeaderTitle}>
          <img alt={"icon"} src={imgSrc} />
          <h1>{props.title}</h1>
        </Link>
        <div className={styles.layoutHeaderRightMenu}>
          <nav>
            <NavLink to="/"
                     activeClassName={styles.active}
                     isActive={checkActive}>Boxes</NavLink>
            <NavLink to="/pokedex"
                     activeClassName={styles.active}>Pokédex</NavLink>
          </nav>
        </div>
      </div>
      <div className={styles.layoutHeaderBottom + " bgGradientDownLight"}>
        <div className={styles.layoutHeaderSubMenuTitle}>
          {props.subtitle}
        </div>
      </div>
    </div>
  )
}

LayoutHeader.propTypes = {
  title: PropTypes.string.isRequired,
  subtitle: PropTypes.string,
}

export { LayoutHeader }
