import React from "react"
import PropTypes from "prop-types"

const Image = ({ src, alt = null, title = null }) =>
  <img className="pk-img" alt={alt} src={src} title={title} />

Image.propTypes = {
  src: PropTypes.string.isRequired,
}

export default Image
