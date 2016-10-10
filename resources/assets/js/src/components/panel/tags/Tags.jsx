import React, {Component} from 'react';
import {Table, TableBody, TableRow, TableRowColumn, TableHeader, TableHeaderColumn} from 'material-ui';
import styles from '../../../../../sass/components/panel/tags/Tags.scss'
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);

class Tags extends Component {
		constructor(props) {
				super(props);
				this.state = {
						currentTag: ""
				};
				this.handleInputChange = this.handleInputChange.bind(this);
				this.handleSubmit = this.handleSubmit.bind(this);
		}

		handleInputChange(e) {
				this.setState({currentTag: e.target.value});
		}

		handleSubmit(e) {
				e.preventDefault();
				var tag = this.state.currentTag;
				this.setState({currentTag: ""});
				console.log(tag);
		}

		render() {
				return (
						<div>
								<form action="post" onSubmit={this.handleSubmit}>
										<input type="text" value={this.state.currentTag} onChange={this.handleInputChange}
													 className={cx("tagSelect")}/>
								</form>
								<Table>
										<TableHeader>

										</TableHeader>
								</Table>
						</div>
				)
		}
}
export default Tags;
module.exports = Tags;