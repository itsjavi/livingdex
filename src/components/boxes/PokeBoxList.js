import React from "react"
import { graphql, useStaticQuery } from "gatsby"
import PokeBox from "./PokeBox"

const boxColumnCount = 3

const PokeBoxList = () => {
  const result = useStaticQuery(graphql`{
      dataJson {
          boxes {
              id
              rows {
                  id
                  cells: pokemon {
                      id
                      pid
                      name
                      name_numeric_avatar
                      image
                      image_shiny
                  }
              }
          }
      }
  }`)

  let boxBuffer = []
  let boxColumns = []

  result["dataJson"]["boxes"].forEach((box, i) => {
    let title = `BOX ${i + 1}`
    boxBuffer = boxBuffer.concat(
      <div className="pk-x-column"><PokeBox boxTitle={title} boxRows={box.rows}/></div>,
    )
    if (boxBuffer.length === boxColumnCount) {
      boxColumns = boxColumns.concat(
        <div className="pk-x-columns">{boxBuffer}</div>,
      )
      boxBuffer = []
    }
  })

  if (boxBuffer.length > 0) {
    boxColumns = boxColumns.concat(
      <div className="pk-x-columns">{boxBuffer}</div>,
    )
  }

  return boxColumns
}

export default PokeBoxList
