import React, {Component} from 'react';
export default class Base extends Component {
		render() {
				return (
						<div>
								{this.props.children}
						</div>
				)
		}
}
module.exports = Base;