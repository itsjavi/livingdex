import React from "react"
import PropTypes from "prop-types"
import PokeBoxRow from "./PokeBoxRow"

const PokeBox = ({ boxTitle, boxRows }) => {
  const rowContents = boxRows.map((row) => {
    return <PokeBoxRow boxRow={row["cells"]}/>
  })

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
