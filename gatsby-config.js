module.exports = {
  pathPrefix: `/livingdex`,
  siteMetadata: {
    title: `Pokémon Living Dex`,
    version: "0.4.1-beta",
    description: `An online Living Dex helper tool.`,
    author: `@itsjavi`,
  },
  plugins: [
    `gatsby-plugin-sass`, // https://www.gatsbyjs.org/docs/bulma/
    `gatsby-plugin-react-helmet`,
    `gatsby-transformer-sharp`,
    `gatsby-plugin-sharp`,
    {
      resolve: `gatsby-transformer-json`,
      options: {},
    },
    {
      resolve: `gatsby-source-filesystem`,
      options: {
        name: `data`,
        path: `${__dirname}/static/data`,
      },
    },
    {
      resolve: `gatsby-source-filesystem`,
      options: {
        name: `media`,
        path: `${__dirname}/static/media`,
      },
    },
    {
      resolve: `gatsby-source-filesystem`,
      options: {
        name: `images`,
        path: `${__dirname}/src/images`,
      },
    },
    {
      // https://www.gatsbyjs.org/packages/gatsby-plugin-manifest/
      resolve: `gatsby-plugin-manifest`,
      options: {
        name: `Pokémon Living Dex`,
        short_name: `LivingDex`,
        start_url: ".",
        background_color: `#75d2b7`,
        theme_color: `#75d2b7`,
        display: `standalone`,
        icon: `src/images/home-logo.png`, // This path is relative to the root of the site.
      },
    },
    {
      resolve: `gatsby-plugin-google-analytics`,
      options: {
        trackingId: "UA-85082661-2",
        head: true,
      },
    },
    // this (optional) plugin enables Progressive Web App + Offline functionality
    // To learn more, visit: https://gatsby.dev/offline
    // `gatsby-plugin-offline`,
  ],
}
