import React from "react"
import PropTypes from "prop-types"

const Image = ({ src, alt = "", title = "", className = ""}) => {
  title = title.replace(/-/g, " ")
  title = title.toLowerCase()
    .split(" ")
    .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
    .join(" ")
  return <>
    <span aria-label={title} data-tooltip={title} className={"pk-link " + className}>
      <img className={"pk-img"} alt={alt} src={src}/>
      {/*<i className="pk-tooltip">{title}</i>*/}
    </span>
  </>
}

Image.propTypes = {
  src: PropTypes.string.isRequired,
}

export default Image
