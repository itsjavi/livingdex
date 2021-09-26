import React from "react"

const BaseHomeRenderPath = "./assets/images/pokemon-home"

function CreateImage(src, alt, className = null) {
  return (
    <img className={className} src={process.env.PUBLIC_URL + "/" + src} alt={alt} />
  )
}

function CreateThumbImage(src, alt, className = null) {
  return (
    <img className={className} src={process.env.PUBLIC_URL + "/" + src} alt={alt} />
  )
}

export { CreateImage, CreateThumbImage, BaseHomeRenderPath }
export default CreateImage
