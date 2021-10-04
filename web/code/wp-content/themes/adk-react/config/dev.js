global.watch = true

const { HOST, PORT, THEME_NAME, PATHS, PROXY_TARGET, htmlHMR } = require('./env.config')
const browserSync = require('browser-sync').create()
const webpack = require('webpack')
const webpackDevMiddleware = require('webpack-dev-middleware')
const webpackHotMiddleware = require('webpack-hot-middleware')
const htmlInjector = require('bs-html-injector')
const webpackConfig = require('./webpack.config')

const bundler = webpack(webpackConfig)

const phpFiles = [
  `${PATHS.base()}/*.php`,
  `${PATHS.src()}/pages/**/*.php`,
  `${PATHS.src()}/pages/*.php`
]

const bsOptions = {
  baseDir: PATHS.dist(),
  files: [
    `${PATHS.src()}/js/**/*.js`,
    {
      match: !htmlHMR ? phpFiles : [`${PATHS.base()}/*.php`],
      // manually sync everything else
      fn: htmlHMR ? synchronize : browserSync.reload()
    }
  ],

  proxy: {
    // proxy local WP install
    target: PROXY_TARGET,

    middleware: [
      // converts browsersync into a webpack-dev-server
      webpackDevMiddleware(bundler, {
        publicPath: `http://${HOST}:${PORT}/wp-content/themes/${THEME_NAME}/`,
        noInfo: true
      }),

      // hot update js && css
      webpackHotMiddleware(bundler)
    ]
  },

  open: false,
  reloadOnRestart: true
}

if (htmlHMR) {
  browserSync.use(htmlInjector, { files: phpFiles })
}

function synchronize (event, file) {
  // activate html injector
  if (file.endsWith('php')) {
    htmlInjector()
  }
}

(async () => {
  browserSync.init(bsOptions)
})()
