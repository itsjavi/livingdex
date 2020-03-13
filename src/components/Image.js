import React from "react"
import PropTypes from "prop-types"

const Image = ({ src, alt = "", title = "", className = "", href = "javascript:;" }) => {
  title = title.replace(/-/g, " ")
  title = title.toLowerCase()
    .split(" ")
    .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
    .join(" ")
  return <>
    <a aria-label={title} data-tooltip={title} className={"pk-link " + className} href={href}>
      <img className={"pk-img"} alt={alt} src={src}/>
      {/*<i className="pk-tooltip">{title}</i>*/}
    </a>
  </>
}

Image.propTypes = {
  src: PropTypes.string.isRequired,
}

export default Image
