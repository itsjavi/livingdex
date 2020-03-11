module.exports = {
  siteMetadata: {
    title: `Pokémon Living Dex`,
    description: `An online Living Dex helper tool.`,
    author: `@route1rodent`,
  },
  plugins: [
    `gatsby-plugin-sass`, // https://www.gatsbyjs.org/docs/bulma/
    `gatsby-plugin-react-helmet`,
    {
      resolve: `gatsby-source-filesystem`,
      options: {
        name: `images`,
        path: `${__dirname}/src/images`,
      },
    },
    `gatsby-transformer-sharp`,
    `gatsby-plugin-sharp`,
    {
      resolve: `gatsby-plugin-manifest`,  // https://www.gatsbyjs.org/packages/gatsby-plugin-manifest/
      options: {
        name: `Pokémon Living Dex`,
        short_name: `Living Dex`,
        start_url: `/`,
        background_color: `#75d2b7`,
        theme_color: `#75d2b7`,
        display: `standalone`,
        icon: `src/images/gatsby-icon.png`, // This path is relative to the root of the site.
      },
    },
    // this (optional) plugin enables Progressive Web App + Offline functionality
    // To learn more, visit: https://gatsby.dev/offline
    // `gatsby-plugin-offline`,
  ],
}
