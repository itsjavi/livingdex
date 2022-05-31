import React from "react"
import styles from "./LayoutHeader.module.css"
import imgSrc from "./box-icon.svg"
import PropTypes from "prop-types"
import {Link} from "react-router-dom"

function LayoutHeader(props) {
  const q = {}
  const checkIsHome = (match, location) => {
    //some additional logic to verify you are in the home URI
    if (!location) {
      return false
    }
    const {pathname} = location
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
          <img alt={"icon"} src={imgSrc}/>
          <h1>{props.title}</h1>
        </Link>
        <div className={styles.layoutHeaderRightMenu}>
          <nav>
            <a title="Boxes (Grouped)" href="https://supereffective.gg/apps/livingdex/national"
               className={styles.active}>
              <i className="icon-box-add"/>
              <span>Boxes (Grouped) </span>
            </a>
            <a title="Boxes (Sorted)" href="https://supereffective.gg/apps/livingdex/national#sorted">
              <i className="icon-box-remove"/>
              <span>Boxes (Sorted)</span>
            </a>
            <a title="Official Twitter" href="https://twitter.com/supereffectiv" target="_blank" rel="noreferrer">
              <i className="icon-twitter" title="Twitter"/>
              <span>Twitter</span>
            </a>
            <a title="Discord server" href="https://discord.gg/3fRXQFtrkN" target="_blank" rel="noreferrer">
              <i className="icon-discord" title="Discord"/>
              <span>Discord</span>
            </a>
          </nav>
        </div>
      </div>
      <div className={styles.layoutHeaderBottom + " bgNotice"} rel={"noindex"}>
        <div className={styles.layoutHeaderSubMenuTitle}>
          ️⚠️ IMPORTANT: This app has been moved to <a
          href="https://supereffective.gg/apps/livingdex">supereffective.gg</a>,
          where it keeps continuously updated with new Pokémon 🍊🍇✨ and features.
          <br/>
          <i style={{opacity: 0.7}}>This app version is discontinued and won't be updated anymore.</i>
        </div>
      </div>
    </div>
  )
}

LayoutHeader.propTypes = {
  title: PropTypes.any.isRequired,
  subtitle: PropTypes.any,
}

export {LayoutHeader}
