import React from "react"
import PropTypes from "prop-types"

const PokeBoxCell = ({ boxCell }) => {
  return (
    <>
      <div className="pk-box-poke column">
        {boxCell.id}
      </div>
    </>
  )
}

PokeBoxCell.propTypes = {
  boxCell: PropTypes.object.isRequired,
}

export default PokeBoxCell
