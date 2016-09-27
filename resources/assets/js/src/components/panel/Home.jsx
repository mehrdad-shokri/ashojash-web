import React, {Component} from 'react';
const progress = require('nprogress');
export default class Base extends Component {
		static contextTypes = {
				router: React.PropTypes.object
		};

		componentWillUnmount() {
				progress.start();
		}

		componentDidMount() {
				progress.done();
		}

		render() {
				return (<div></div>)
		}
}
module.exports = Base;