import React from "react"
import styles from "./Layout.module.css"
import {LayoutHeader} from "../../components/LayoutHeader/LayoutHeader"

function BoxesPage() {
  let title = <span>Living Dex</span>
  let subtitle = ""

  const layoutStyle = {
    background: `url(${process.env.PUBLIC_URL}/preview-alpha.png) no-repeat center center fixed`,
    backgroundSize: 'cover',
    minHeight: '100vh',
    paddingTop: '100px',
    overflow: 'hidden',
  }
  return (
    <div className="app themeTeal bgGradientDown">
      <div className={styles.layout}>
        <LayoutHeader title={title} subtitle={subtitle}/>
        <div className={styles.layoutBody} style={layoutStyle}>
          <div className={styles.layoutBodyInner}></div>
        </div>
      </div>
    </div>
  )
}

BoxesPage.propTypes = {}

export default BoxesPage
