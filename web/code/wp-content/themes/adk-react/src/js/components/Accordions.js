import { select, selectAll } from '../helpers'

class Accordions {
  constructor ({ buttonClass, containerSelector, singleActive, activeIndex }) {
    this.buttonClass = buttonClass || '.accordion_button'
    this.containerSelector = containerSelector || false
    this.singleActive = singleActive !== null ? singleActive : false
    this.activeIndex = activeIndex !== null ? activeIndex : false
    this.accordionButtons = selectAll(`${this.containerSelector} ${this.buttonClass}`)

    if (!this.containerSelector) {
      console.log('Tabs Error: missing container class in options')
    }

    this.checkOthers = this.checkOthers.bind(this)

    this.init()
  }

  checkOthers (elem) {
    const { accordionButtons, containerSelector } = this

    for (let i = 0; i < this.accordionButtons.length; i++) {
      if (accordionButtons[i] !== elem) {
        if (accordionButtons[i].getAttribute('aria-expanded') === 'true') {
          accordionButtons[i].setAttribute('aria-expanded', 'false')
          let content = accordionButtons[i].getAttribute('aria-controls')
          select(`${containerSelector} #${content}`).setAttribute('aria-hidden', 'true')
          select(`${containerSelector} #${content}`).style.display = 'none'
        }
      }
    }
  }

  init () {
    const { accordionButtons, checkOthers, singleActive, activeIndex, containerSelector } = this

    accordionButtons.forEach(el => {
      el.addEventListener('click', e => {
        const control = e.currentTarget
        const accordionContent = control.getAttribute('aria-controls')
        const selector = `${containerSelector} #${accordionContent}`

        if (singleActive) {
          checkOthers(control)
        }

        const isAriaExp = control.getAttribute('aria-expanded')
        const newAriaExp = isAriaExp === 'false' ? 'true' : 'false'
        control.setAttribute('aria-expanded', newAriaExp)

        const isAriaHid = select(selector).getAttribute('aria-hidden')
        if (isAriaHid === 'true') {
          select(selector).setAttribute('aria-hidden', 'false')
          select(selector).style.display = 'block'
        } else {
          select(selector).setAttribute('aria-hidden', 'true')
          select(selector).style.display = 'none'
        }
      })
    })

    if (activeIndex !== false && typeof activeIndex !== 'undefined') {
      let initialExpanded = accordionButtons[activeIndex]

      if (initialExpanded) {
        initialExpanded.click()
      } else {
        console.log('Error: invalid active index')
      }
    }
  }
}

export default Accordions
