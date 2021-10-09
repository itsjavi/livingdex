import React from "react"
import styles from "./Layout.module.css"
import {LayoutHeader} from "../LayoutHeader/LayoutHeader"
import PropTypes from "prop-types"

function Layout(props) {
  return (
    <div className={styles.layout}>
      <LayoutHeader title={props.title} subtitle={props.subtitle} />
      <div className={styles.layoutBody}>
        <div className={styles.layoutBodyInner}>
          {props.children}
        </div>
      </div>
      {/*<LayoutFooter actions={props.footerActions}>*/}
      {/*  /!*{props.footer}*!/*/}
      {/*  <Panel header={"Test"}>Test</Panel>*/}
      {/*</LayoutFooter>*/}
    </div>
  )
}

Layout.propTypes = {
  title: PropTypes.any.isRequired,
  subtitle: PropTypes.any,
  footer: PropTypes.any,
  footerActions: PropTypes.any,
}

export { Layout }
