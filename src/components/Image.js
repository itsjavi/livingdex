import React from "react"
import PropTypes from "prop-types"

const BaseHomeRenderPath = "./assets/images/home/pokemon/regular/"

function Image(props) {
  return (
    <img className={props.className} src={process.env.PUBLIC_URL + "/" + props.src} alt={props.alt} />
  )
}

Image.propTypes = {
  src: PropTypes.string.isRequired,
  alt: PropTypes.string,
  className: PropTypes.string,
}

export default Image
export { Image, BaseHomeRenderPath }
