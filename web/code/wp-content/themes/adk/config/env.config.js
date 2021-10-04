const path = require('path')

module.exports = {
  THEME_NAME: 'adk',
  PROXY_TARGET: 'localhost:8000',
  htmlHMR: process.argv[2] === 'html' || false,
  HOST: 'localhost',
  PORT: 3000,
  PATHS: {
    src: unipath('src'),
    dist: unipath(path.resolve(__dirname, '../dist')),
    modules: unipath('node_modules'),
    base: unipath('.')
  }
}

function unipath (base) {
  return function join () {
    const _paths = [base].concat(Array.from(arguments))
    return path.resolve(path.join.apply(null, _paths))
  }
}
