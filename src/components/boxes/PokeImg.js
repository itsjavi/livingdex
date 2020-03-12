import React from "react"
import PropTypes from "prop-types"
import { graphql, StaticQuery } from "gatsby"
import Img from "gatsby-image"

// from: https://stackoverflow.com/questions/55122752/reusable-gatsby-image-component-with-dynamic-image-sources
const PokeImg = ({ src, alt = null, title = null }) => (
  <StaticQuery
    query={graphql`
      query {
        images: allFile(filter: {extension: {eq: "png"}, relativeDirectory: {regex: "/renders\\/[0-9].*/"}}) {
          edges {
            node {
              relativePath
              name
              childImageSharp {
                fluid(maxWidth: 300) {
                  ...GatsbyImageSharpFluid
                }
              }
            }
          }
        }
      }
    `}
    render={data => {
      const image = data.images.edges.find(n => {
        return n.node.relativePath.includes(src)
      })
      if (!image) {
        return null
      }

      //const imageSizes = image.node.childImageSharp.sizes; sizes={imageSizes}
      return <Img alt={alt} fluid={image.node.childImageSharp.fluid}/>
    }}
  />
)
PokeImg.propTypes = {
  src: PropTypes.string.isRequired,
}

export default PokeImg
