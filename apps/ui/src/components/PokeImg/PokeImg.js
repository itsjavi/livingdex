import React from "react"
import "./PokeImg.css"

const usePixelArt = false // false = home renders, true = menu icons

function PokeImg(slug, alt, shiny = false, classNameExtra = "") {
  let prefix = usePixelArt ? "pkmi" : "pkm"
  let src = usePixelArt ? "placeholder-68x56.png" : "placeholder-64x64.png"
  let className = `${prefix} ${prefix}-${slug}`
  if (shiny) {
    className += " shiny"
  }
  return (
    <span className={prefix + "-wrapper" + (classNameExtra.length > 0 ? (" " + classNameExtra) : "")}>
      <img className={className} src={process.env.PUBLIC_URL + "/assets/images/" + src} alt={alt} />
    </span>
  )
}

export { PokeImg }

