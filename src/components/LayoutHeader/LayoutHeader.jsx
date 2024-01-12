import React from "react"
import styles from "./LayoutHeader.module.css"
import imgSrc from "./box-icon.svg"
import PropTypes from "prop-types"
import { Link } from "react-router-dom"

function LayoutHeader(props) {
  return (
    <div className={styles.layoutHeader}>
      <div className={`${styles.layoutHeaderTop} bgGradientLeft`}>
        <Link to="/" className={styles.layoutHeaderTitle}>
          <img alt={"icon"} src={imgSrc} />
          <h1>{props.title}</h1>
        </Link>
        <div className={styles.layoutHeaderRightMenu}>
          <nav>
            <a
              title="Box Tracker"
              href="https://supereffective.gg/apps/livingdex/national"
              className={styles.active}
            >
              <i className="icon-box-add" />
              <span>Box Tracker </span>
            </a>
            <a title="Dex Tracker" href="https://itsjavi.com/pokedex-tracker">
              <i className="icon-books" />
              <span>Dex Tracker</span>
            </a>
            <a
              title="Official Twitter"
              href="https://twitter.com/supereffectiv"
              target="_blank"
              rel="noreferrer"
            >
              <i className="icon-twitter" title="Twitter" />
              <span>Twitter/X</span>
            </a>
            <a
              title="Discord server"
              href="https://discord.gg/3fRXQFtrkN"
              target="_blank"
              rel="noreferrer"
            >
              <i className="icon-discord" title="Discord" />
              <span>Discord</span>
            </a>
          </nav>
        </div>
      </div>
      <div className={`${styles.layoutHeaderBottom} bgNotice`} rel={"noindex"}>
        <div className={styles.layoutHeaderSubMenuTitle}>
          <article>
            ️🚧 IMPORTANT: This Living Dex Box Organizer web app has been moved
            to{" "}
            <a href="https://supereffective.gg/apps/livingdex">
              supereffective.gg
            </a>
            , where it keeps continuously updated with new Pokémon and features.
            <br />
            <br />
            In the other side, if you are looking for a{" "}
            <b>simpler Pokédex Tracker </b>(without the hurdle of organizing
            boxes), you can find it in{" "}
            <a href="https://itsjavi.com/pokedex-tracker">
              itsjavi.com/pokedex-tracker
            </a>
            , our newest tool, and companion of Supereffective.gg.
            <br />
            <br />
            <i style={{ opacity: 0.7 }}>
              This app version is discontinued and won't be updated anymore.
            </i>
          </article>
        </div>
      </div>
    </div>
  )
}

LayoutHeader.propTypes = {
  title: PropTypes.any.isRequired,
  subtitle: PropTypes.any,
}

export { LayoutHeader }
