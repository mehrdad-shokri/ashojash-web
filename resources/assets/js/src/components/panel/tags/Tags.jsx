import React, {Component} from 'react';
import {Table, TableBody, TableRow, TableRowColumn, TableHeader, TableHeaderColumn, TableFooter} from 'material-ui';
import styles from '../../../../../sass/components/panel/tags/Tags.scss'
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
const tableData = [
		{
				name: 'John Smith',
				level: 1,
		},
		{
				name: 'Randal White',
				level: 1,
		},
		{
				name: 'Stephanie Sanders',
				level: 'Employed',
		},
		{
				name: 'Steve Brown',
				level: 'Employed',
		},
		{
				name: 'Joyce Whitten',
				level: 'Employed',
		},
		{
				name: 'Samuel Roberts',
				level: 'Employed',
		},
		{
				name: 'Adam Moore',
				level: 'Employed',
		},
];

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
								<Table selectable={false}>
										<TableHeader displaySelectAll={false} adjustForCheckbox={false}>
												<TableRow >
														<TableHeaderColumn tooltip="اسم تگ"
																							 tooltipStyle={{fontSize: 14}}
																							 style={{fontSize: 20}}>نام
														</TableHeaderColumn>
														<TableHeaderColumn tooltip="سطح کمتر، اولویت بیشتری در جستجو دارد"
																							 tooltipStyle={{fontSize: 14}}
																							 style={{fontSize: 20}}>سطح
														</TableHeaderColumn>
												</TableRow>
										</TableHeader>
										<TableBody
												displayRowCheckbox={false}>
												{tableData.map((row, index) => (
														<TableRow key={index} selected={row.selected}>
																<TableRowColumn style={{fontSize: 14}}>{row.name}</TableRowColumn>
																<TableRowColumn style={{fontSize: 14}}>{row.level}</TableRowColumn>
														</TableRow>
												))}
										</TableBody>
								</Table>
						</div>
				)
		}
}
export default Tags;
module.exports = Tags;