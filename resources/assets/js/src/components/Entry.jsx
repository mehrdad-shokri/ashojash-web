import React, {Component} from 'react';
const progress = require('nprogress/nprogress.js')
export default class Entry extends Component {
		static contextTypes = {
				router: React.PropTypes.object
		};


		componentWillMount() {
				this.context.router.push('/admin/panel');
		}

		componentWillUnmount() {
				progress.start();
		}
		componentDidMount(){
				progress.done();
		}

		render() {
				return (
						<div></div>
				)
		}
}