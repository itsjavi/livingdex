import React from "react"
import { graphql, useStaticQuery } from "gatsby"
import PokeBox from "./boxes/PokeBox"

const Boxes = () => {
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
  return result["dataJson"]["boxes"].map((box, i) => {
    let title = `BOX ${i + 1}`
    let rows = box["rows"]
    //return  <pre>{JSON.stringify(rows, null, 4)}</pre>;
    return <PokeBox boxTitle={title} boxRows={box.rows}/>
  })
}

export default Boxes
