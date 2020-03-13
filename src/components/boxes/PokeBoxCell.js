import React from "react"
import PropTypes from "prop-types"
import Image from "../Image"

const PokeBoxCell = ({ boxCell }) => {
  let title = `${boxCell.pid} - ${boxCell.name}`
  let classTags = ""

  if (boxCell.tags && boxCell.tags.length > 0) {
    classTags = " pk-tag-" + boxCell.tags.join(" pk-tag-")
  }

  let classNameStr = `pk-box-poke${classTags} column`

  if (!boxCell.tags.includes("has-gigantamax")) {
    return (
      <>
        <div className={classNameStr}>
          <Image title={title} alt={title} src={boxCell.image}/>
        </div>
      </>
    )
  }
  return (
    <>
      <div className={classNameStr}>
        <Image className="pk-img-default" title={title} alt={title} src={boxCell.image}/>
        <Image className="pk-img-hover" title={title + "-gigantamax"} alt={title + "-gigantamax"}
               src={boxCell.image.replace(".png", "-gigantamax.png")}/>
      </div>
    </>
  )
}

PokeBoxCell.propTypes = {
  boxCell: PropTypes.object.isRequired,
}

export default PokeBoxCell
