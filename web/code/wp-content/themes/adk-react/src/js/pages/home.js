import 'react-hot-loader'
import React from 'react'
import ReactDOM from 'react-dom'
import ReactComponent from '../react/ReactComponent'

/* eslint-disable-next-line */
theme.pages.home = {
  init () {
    console.log('homepage HMR Working')
  },

  bindEvents () {
    console.log('vanilla js here!')

    ReactDOM.render(<ReactComponent />, document.querySelector('.c-react'))
  }
}
