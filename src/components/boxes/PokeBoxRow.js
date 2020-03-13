import React from "react"
import PropTypes from "prop-types"
import PokeBoxCell from "./PokeBoxCell"

const PokeBoxRow = ({ boxRow }) => {
  const cells = boxRow.map((cell) => {
    return <PokeBoxCell boxCell={cell}/>
  })
  // TODO add placeholder cells
  return (
    <>
      <div className="pk-box-row columns is-mobile">
        {cells}
      </div>
    </>
  )
}

PokeBoxRow.propTypes = {
  boxRow: PropTypes.arrayOf(PropTypes.object).isRequired,
}

export default PokeBoxRow
