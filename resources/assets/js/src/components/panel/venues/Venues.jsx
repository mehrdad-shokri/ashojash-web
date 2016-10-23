import React, {Component} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import {venueMessage, getVenues} from '../../../actions'
import {Link} from 'react-router';
const progress = require('nprogress');
import styles from '../../../../../sass/components/panel/venues/Venues.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
import {
		Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn
}    from 'material-ui/Table';

class Venues extends Component {
		static contextTypes = {
				router: React.PropTypes.object
		}

		constructor(props) {
				super(props);
				this.state = {height: "500px"};
		}


		componentDidMount() {
				if (!this.props.hasVenues) {
						progress.start();
						this.props.getVenues();
				}
		}

		componentDidUpdate() {
				if (!this.props.isRequesting && (this.props.hasVenues || this.props.hasMessage)) {
						progress.done();
				}
		}

		render() {
				return (
						<div>
								<Table height={this.state.height}
											 fixedHeader={true}>
										<TableHeader
												displaySelectAll={false}
												adjustForCheckbox={false}
										>
												<TableRow>
														<TableHeaderColumn tooltip="نام رستوران" style={{fontSize: 18}}
																							 tooltipStyle={{fontSize: 13}}>نام</TableHeaderColumn>

														<TableHeaderColumn tooltip="آدرس"
																							 tooltipStyle={{fontSize: 13}}
																							 style={{fontSize: 18}}>آدرس</TableHeaderColumn>

												</TableRow>
										</TableHeader>

										<TableBody displayRowCheckbox={false}>
												{
														this.props.venues ? this.props.venues.map((item)=> {
																return (
																		<TableRow key={item.slug}
																							selectable={false}
																							className={cx("tableRow")}
																		>
																				<TableRowColumn style={{fontSize: 15}}>
																						<Link to={`/admin/panel/venues/${item.slug}`}
																									className={cx('link')}
																						>
																								{item.name}
																						</Link>
																				</TableRowColumn>
																				<TableRowColumn style={{fontSize: 15}}>
																						<Link to={`/admin/panel/venues/${item.slug}`}
																									className={cx('link')}
																						>
																								{item.location.address}
																						</Link>
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
				getVenues,
				venueMessage,
		}, dispatch);
}

function mapStateToProps(state) {
		return {
				isRequesting: state.venues.isRequesting,
				venues: state.venues.venues,
				hasVenues: state.venues.hasVenues,
				hasMessage: state.venues.hasMessage,
				message: state.venues.message,
		};
}
export default connect(mapStateToProps, mapDispatchToProps)(Venues);
module.exports = connect(mapStateToProps, mapDispatchToProps)(Venues);