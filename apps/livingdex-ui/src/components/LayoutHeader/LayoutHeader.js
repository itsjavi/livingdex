import React from "react"
import styles from "./LayoutHeader.module.css"
import imgSrc from "./box-icon.svg"
import PropTypes from "prop-types"
import { Link, NavLink } from "react-router-dom"
import useQueryOptions from "../../hooks/useQueryOptions";

function LayoutHeader(props) {
  const q = useQueryOptions()
  const checkIsHome = (match, location) => {
    //some additional logic to verify you are in the home URI
    if (!location) {
      return false
    }
    const { pathname } = location
    return pathname === "/"
  }
  const checkBoxesPageGrouped = (match, location) => {
    return checkIsHome(match, location) && (q.boxStyle === 'grouped')
  }
  const checkBoxesPageSorted = (match, location) => {
    return checkIsHome(match, location) && (q.boxStyle === 'sorted')
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
            <NavLink title="Boxes (Grouped)" to="/"
                     activeClassName={styles.active}
                     isActive={checkBoxesPageGrouped}>
              <i className="icon-box-add"/>
              <span>Boxes (Grouped) </span>
            </NavLink>
            <NavLink title="Boxes (Sorted)" to="/?mode=sorted"
                     activeClassName={styles.active}
                     isActive={checkBoxesPageSorted}>
              <i className="icon-box-remove"/>
              <span>Boxes (Sorted)</span>
            </NavLink>
            <NavLink title="Pokédex" to="/pokedex"
                     activeClassName={styles.active}>
              <i className="icon-books"/>
              <span>Pokédex</span>
            </NavLink>
            <a title="Github project" href="https://github.com/itsjavi/livingdex#pok%C3%A9mon-living-dex" target="_blank" rel="noreferrer">
              <i className="icon-github" title="Github"/>
              <span>Github</span>
            </a>
            {/*<a href="https://blog.itsjavi.com/" target="_blank">*/}
            {/*  <small>Created by <b>@itsjavi</b></small>*/}
            {/*</a>*/}
          </nav>
        </div>
      </div>
      <div className={styles.layoutHeaderBottom + " bgGradientDownLight"}>
        <h2 className={styles.layoutHeaderSubMenuTitle}>
          {props.subtitle}
        </h2>
      </div>
    </div>
  )
}

LayoutHeader.propTypes = {
  title: PropTypes.any.isRequired,
  subtitle: PropTypes.any,
}

export { LayoutHeader }
