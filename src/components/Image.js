import React from "react"
import PropTypes from "prop-types"

function disableClick(event) {
  event.preventDefault();
  return false;
}

const Image = ({ src, alt = "", title = "", className = ""}) => {
  title = title.replace(/-/g, " ")
  title = title.toLowerCase()
    .split(" ")
    .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
    .join(" ")
  return <>
    <a aria-label={title} data-tooltip={title} className={"pk-link " + className} href="#" onClick={disableClick}>
      <img className={"pk-img"} alt={alt} src={src}/>
      {/*<i className="pk-tooltip">{title}</i>*/}
    </a>
  </>
}

Image.propTypes = {
  src: PropTypes.string.isRequired,
}

export default Image
