import { hot } from 'react-hot-loader/root'
import React, { Component } from 'react'
import Header from '@/features/subComponent/Header'
class ReactComponent extends Component {
  constructor () {
    super()

    this.state = {
      count: 200,
      label: 'component'
    }
  }

  render () {
    return (
      <div>
        <Header />
        <h2 className="h2" onClick={() => this.setState({ count: this.state.count + 10 })}>
          This is a react {this.state.label} # {this.state.count}
        </h2>
      </div>
    )
  }
}

export default hot(ReactComponent)
