module.exports = {
  // proxy API requests to Valet during development
  devServer: {
    proxy: process.env.BACKEND_DOMAIN
  },

  // output built static files to Laravel's public dir.
  // note the "build" script in package.json needs to be modified as well.
  outputDir: "../public",
filenameHashing: false,
  // modify the location of the generated HTML file.
  // make sure to do this only in production.
  indexPath:
    process.env.NODE_ENV === "production"
      ? "../resources/views/layouts/app.blade.php"
      : "index.html",
  chainWebpack: config => {
    // Pug Loader
    config.module
      .rule("pug")
      .test(/\.pug$/)
      .use("pug-plain-loader")
      .loader("pug-plain-loader")
      .end();
    const oneOfsMap = config.module.rule("scss").oneOfs.store;
    oneOfsMap.forEach(item => {
      item
        .use("sass-resources-loader")
        .loader("sass-resources-loader")
        .options({
          // Provide path to the file with resources
          resources: [
            "./src/assets/scss/_smart-grid.scss",
            "./src/assets/scss/_variables.scss",
            "./src/assets/scss/_mixins.scss"
          ]

          // Or array of paths
        })
        .end();
    });
  }
};
