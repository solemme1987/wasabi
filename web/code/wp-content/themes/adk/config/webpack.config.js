const { PATHS, HOST, PORT, THEME_NAME } = require('./env.config')
const webpack = require('webpack')
const fs = require('fs')
const WriteFilePlugin = require('write-file-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const autoprefixer = require('autoprefixer')
const ManifestPlugin = require('webpack-manifest-plugin')
const StylelintPlugin = require('stylelint-webpack-plugin')

let ENV = process.env.NODE_ENV
const WATCH = global.watch || false
console.log('ENV', ENV)

module.exports = {
  entry: {
    // custom: './src/scss/custom.scss',
    ...getEntry()
  },

  output: {
    path: PATHS.dist(),
    publicPath: `http://${HOST}:${PORT}/wp-content/themes/${THEME_NAME}/`,
    filename: ENV === 'production' ? 'js/[name].bundle.[chunkhash:8].js' : 'js/[name].js',
    sourceMapFilename: '[file].map'
  },

  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'eslint-loader',
        options: {
          // eslint options (if necessary)
        }
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: { loader: 'babel-loader' }
      },
      {
        test: /\.(png|jpe?g|gif)$/i,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: 'img/[name].[contenthash].[ext]'
            }
          }
        ]
      },
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              hmr: ENV === 'development'
            }
          },
          {
            loader: 'css-loader',
            options: {
              url: false,
              sourceMap: ENV === 'development'
            }
          },
          {
            loader: require.resolve('postcss-loader'),
            options: {
              ident: 'postcss',
              plugins: () => [
                require('postcss-flexbugs-fixes'),
                autoprefixer({
                  browsers: [
                    '>1%',
                    'last 4 versions',
                    'Firefox ESR',
                    'not ie < 9'
                  ],
                  flexbox: 'no-2009',
                  grid: true
                })
              ]
            }
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: ENV === 'development',
              prependData: `$debug: ${ENV === 'development' ? 'true' : 'false'};`
            }
          }
        ]
      }
    ]
  },

  devtool: ENV === 'production' ? false : 'inline-source-map',

  optimization: {
    splitChunks: {
      // include all types of chunks
      chunks: 'all',
      name: 'vendor',
      minChunks: 3
    }
  },

  plugins: getPlugins(),
  mode: ENV,
  watch: WATCH
}

function getEntry () {
  let entries = {}

  const pages = fs.readdirSync('./src/js/pages').filter(file => {
    return file.match(/.*\.js$/)
  })
  for (let page of pages) {
    const name = page.match(/.*(?=\.)/g)[0]

    entries[name] = ENV === 'development'
      ? [`./src/js/pages/${page}`, 'webpack-hot-middleware/client']
      : [`./src/js/pages/${page}`]
  }

  entries.global = []
  if (ENV === 'development') {
    entries.global.push('webpack-hot-middleware/client')
  }
  entries.global.push('./src/js/pages/global.js')

  return entries
}

function getPlugins () {
  // Add static to be copied from src to dist
  const staticDirs = ['pages', 'img', 'fonts']

  const copyPatterns = staticDirs.map(dir => (
    { from: `${PATHS.src()}/${dir}`, to: `${PATHS.dist()}/${dir}` })
  )

  const plugins = [
    // Clean the dist folder
    new CleanWebpackPlugin({
      cleanAfterEveryBuildPatterns: [
        ...staticDirs.map(dir => `!${dir}/**/*`),
        '!manifest.json'
      ]
    }),

    // Copy template files and images to dist
    new CopyWebpackPlugin(copyPatterns),

    // Compile SCSS files to plain css
    new MiniCssExtractPlugin({
      moduleFilename: ({ name }) => {
        const fileName = name === 'global' ? 'style' : name

        return ENV === 'production'
          ? `css/${fileName}.[contenthash].css`
          : `css/${fileName}.css`
      }
    }),

    // Outout a manifest file
    new ManifestPlugin({
      publicPath: '/'
    })
  ]

  switch (ENV) {
    case 'production':
      break

    case 'development':
      plugins.push(new webpack.optimize.OccurrenceOrderPlugin())
      plugins.push(new webpack.HotModuleReplacementPlugin())
      plugins.push(new webpack.NoEmitOnErrorsPlugin())
      plugins.push(new WriteFilePlugin())
      plugins.push(new StylelintPlugin({fix: true}))
      break
  }

  return plugins
}
