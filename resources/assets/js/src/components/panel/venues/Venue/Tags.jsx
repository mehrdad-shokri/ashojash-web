import React, {Component} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
const progress = require('nprogress');
import {getVenueTags} from '../../../../actions'
import {
		Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn
}    from 'material-ui/Table';
import AddTag from './AddTag';
class Tags extends Component {
		constructor(props) {
				super(props);
				this.state = {height: "400px"};
		}

		componentDidMount() {
				this.props.getVenueTags(this.props.slug)
		}

		componentDidUpdate() {
				if (this.props.isRequesting) {
						progress.start();
				}
				else {
						progress.done();
				}
		}

		render() {
				return (
						<div>
								<AddTag/>
								<Table
										height={this.state.height}
										fixedHeader={true}>
										<TableHeader
												displaySelectAll={false}
												adjustForCheckbox={false}
										>
												<TableRow>
														<TableHeaderColumn tooltip="نام تگ" style={{fontSize: 18}}
																							 tooltipStyle={{fontSize: 13}}>نام</TableHeaderColumn>

														<TableHeaderColumn tooltip="وزن تگ برای این رستوران"
																							 tooltipStyle={{fontSize: 13}}
																							 style={{fontSize: 18}}>وزن</TableHeaderColumn>

												</TableRow>
										</TableHeader>

										<TableBody displayRowCheckbox={false}>
												{
														this.props.venueTags ? this.props.venueTags.map((item)=> {
																return (
																		<TableRow key={item.id}
																							selectable={false}>
																				<TableRowColumn style={{fontSize: 15}}>
																						{item.name}
																				</TableRowColumn>
																				<TableRowColumn style={{fontSize: 15}}>
																						{item.weight}
																				</TableRowColumn>
																		</TableRow>
																)
														}) : ""
												}
										</TableBody>
								</Table>
						</div>
				)
		}

}

function mapDispatchToProps(dispatch) {
		return bindActionCreators({
				getVenueTags: getVenueTags
		}, dispatch);
}

function mapStateToProps(state) {
		return {
				venueTags: state.venues.venueTags,
				isRequesting: state.venues.isRequesting
		};
}
export default connect(mapStateToProps, mapDispatchToProps)(Tags);