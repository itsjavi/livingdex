import React from "react"
import PropTypes from "prop-types"
import Image from "../Image"

const PokeBoxCell = ({ boxCell }) => {
  let title = `${boxCell.pid} - ${boxCell.name}`;

  return (
    <>
      <div title={title} className="pk-box-poke column">
        <Image title={title} alt={title} src={boxCell.image} />
      </div>
    </>
  )
}

PokeBoxCell.propTypes = {
  boxCell: PropTypes.object.isRequired,
}

export default PokeBoxCell
