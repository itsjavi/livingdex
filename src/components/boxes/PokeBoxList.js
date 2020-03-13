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
                      tags
                  }
              }
          }
      }
  }`)

  let boxBuffer = []
  let boxColumns = []

  result["dataJson"]["boxes"].forEach((box, i) => {
    let title = `BOX ${i + 1}`
    boxBuffer.push(
      <div className="column is-one-third-widescreen is-half is-full-mobile"><PokeBox boxTitle={title} boxRows={box.rows}/></div>,
    )
    if (boxBuffer.length === boxColumnCount) {
      boxColumns.push(
        <div className="columns">{boxBuffer}</div>,
      )
      boxBuffer = []
    }
  })

  if (boxBuffer.length > 0) {
    boxColumns.push(
      <div className="columns">{boxBuffer}</div>,
    )
  }

  if (boxBuffer.length < boxColumnCount) {
    for (let i = boxColumnCount.length; i < boxColumnCount; i++) {
      boxColumns.push(
        <div className="columns">&nbsp;</div>,
      )
    }
  }

  boxColumns.push(<div style={{ clear: "both" }}/>)

  return boxColumns
}

export default PokeBoxList
