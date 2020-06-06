import React from "react"
import PropTypes from "prop-types"
import PokeBoxRow from "./PokeBoxRow"
import PokeBoxRowGap from "./PokeBoxRowGap"

const boxRowCount = 5

const PokeBox = ({ boxTitle, boxRows }) => {
  let rowContents = boxRows.map((row, i) => {
    return <PokeBoxRow key={i} boxRow={row["cells"]}/>
  })

  // fill gaps
  if (rowContents.length < boxRowCount) {
    for (let i = rowContents.length; i < boxRowCount; i++) {
      rowContents.push(
        <PokeBoxRowGap key={i}/>,
      )
    }
  }

  return (
    <>
      <div className="pk-box-container hero">
        <div className="hero-head">
          <p className="title">{boxTitle}</p>
        </div>
        <div className="hero-body">
          {rowContents}
        </div>
      </div>
    </>
  )
}

PokeBox.propTypes = {
  boxTitle: PropTypes.string.isRequired,
  boxRows: PropTypes.arrayOf(PropTypes.object).isRequired,
}

export default PokeBox
