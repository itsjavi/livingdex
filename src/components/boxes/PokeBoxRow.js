import React from "react"
import PropTypes from "prop-types"
import PokeBoxCell from "./PokeBoxCell"
import PokeBoxCellGap from "./PokeBoxCellGap"

const boxRowCellCount = 6

const PokeBoxRow = ({ boxRow }) => {
  let cells = boxRow.map((cell) => {
    return <PokeBoxCell boxCell={cell}/>
  })
  // fill gaps
  if (cells.length < boxRowCellCount) {
    for (let i = cells.length; i < boxRowCellCount; i++) {
      cells = cells.concat(
        <PokeBoxCellGap/>,
      )
    }
  }
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
