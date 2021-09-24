import React from "react"

const BaseHomeRenderPath = "./assets/images/home"

function CreateImage(src, alt, className = null) {
  return (
    <img className={className} src={process.env.PUBLIC_URL + "/" + src} alt={alt} />
  )
}

export default CreateImage
export { CreateImage, BaseHomeRenderPath }
