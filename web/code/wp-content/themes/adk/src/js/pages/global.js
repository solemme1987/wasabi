import { select, selectAll } from '../helpers'
import Accordions from '../components/Accordions'
import '../../scss/style.scss'

window.theme = {
  bodyID: null,
  init () {
    this.bodyID = select('body').id

    // envoke page specific js
    if (this.pages.hasOwnProperty(this.bodyID)) {
      const page = this.pages[this.bodyID]

      // initialize init & bindEvents functions from page specific js (e.g. home.js)
      if (page.hasOwnProperty('init') && typeof page.init === 'function') {
        page.init(this)
      }

      if (page.hasOwnProperty('bindEvents') && typeof page.bindEvents === 'function') {
        page.bindEvents()
      }
    }

    // sitewide js
    this.bindEvents()
  },
  bindEvents () {
    selectAll('.js-accordion').forEach(({ id, dataset: { single, active } }) => {
      /* eslint-disable-next-line */
      let accordion = new Accordions({
        singleActive: typeof single !== 'undefined' ? parseInt(single, 10) : null,
        activeIndex: typeof active !== 'undefined' ? parseInt(active, 10) : null,
        containerSelector: id ? `#${id}` : '.js-accordion',
        buttonClass: '.c-accordion__button'
      })
    })
  },
  pages: {}
}

document.addEventListener('DOMContentLoaded', (event) => {
  window.theme.init()
})
