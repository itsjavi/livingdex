import React from "react"
import "./PokeImg.css"

const USE_PIXELART = false // false = home renders, true = menu icons

function PokeImg(slug, alt, shiny = false, classNameExtra = "", usePixelArt = USE_PIXELART) {
  let prefix = usePixelArt ? "pkmi" : "pkm"
  let src = usePixelArt ? "placeholder-68x56.png" : "placeholder-64x64.png"
  classNameExtra = (classNameExtra.length > 0 ? (" " + classNameExtra) : "")
  let classNameExtraWrapper = (classNameExtra.length > 0 ? (classNameExtra + "-wrapper") : "")
  let className = `${prefix} ${prefix}-${slug}` + classNameExtra
  if (shiny) {
    className += " shiny"
  }
  return (
    <span className={prefix + "-wrapper" + classNameExtraWrapper}>
      <img className={className} src={process.env.PUBLIC_URL + "/placeholders/" + src} alt={alt}/>
    </span>
  )
}

export {PokeImg}

