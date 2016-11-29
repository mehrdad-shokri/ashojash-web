const progress = require('nprogress');
import React, {Component} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import {getCollections} from '../../../actions'
import Fab from './AddCollectionFab';
import styles from '../../../../../sass/components/panel/collections/Collections.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
const moment = require('moment-jalaali');
moment.loadPersian();
require('moment/locale/fa');

class Collections extends Component {
		render() {
				let {location} = this.props;
				let isModal = (
						location.state &&
						location.state.modal &&
						this.previousChildren
				);

				if (!this.props.collections) {
						return (
								<div>
										<table className={cx('u-full-width', 'collections')}>
												<thead>
												<tr>
														<th>نام</th>
														<th>شروع</th>
														<th><i className="md">access_time</i></th>
														<th>پایان</th>
														<th>فعال</th>
												</tr>
												</thead>
												<tbody></tbody>
										</table>
								</div>)
				}
				else {
						return (
								<div>
										<table className={cx('u-full-width', 'collections')}>
												<thead>
												<tr>
														<th>نام</th>
														<th>شروع</th>
														<th><i className="md">access_time</i></th>
														<th>پایان</th>
														<th>فعال</th>
												</tr>
												</thead>
												<tbody>
												{
														this.props.collections.map(collection=>
																<tr key={collection.slug}
																		className={cx(collection.active ? "activeCollection" : "inactiveCollection")}>
																		<td>{collection.name}</td>
																		<td>{moment.unix(collection.starts_at).format("dddd jDo jMMMM jYY")}</td>
																		<td>{moment.unix(collection.starts_at).format("H:m")}</td>
																		<td>{moment.unix(collection.ends_at).fromNow()}</td>
																		<td>{collection.active == 1 ?
																				<i className={cx("fa fa-check", "active")}></i> :
																				<i className={cx("fa fa-times", "inactive")}></i>}</td>
																</tr>
														)
												}
												</tbody>
										</table>
										<Fab pathname={this.props.location.pathname}/>
								</div>
						)
				}
		}

		componentDidUpdate() {
				if (this.props.isRequesting) {
						progress.start();
				}
				else {
						progress.done();
				}
		}

		componentDidMount() {
				if (!this.props.hasCollections) {
						this.props.getCollections();
				}
				progress.done();
		}

		componentWillUnmount() {
				progress.start();
		}
}
function mapDispatchToProps(dispatch) {
		return bindActionCreators({getCollections: getCollections}, dispatch);
}

function mapStateToProps(state) {
		return {
				isRequesting: state.collections.isRequesting,
				collections: state.collections.collections,
				hasCollections: state.collections.hasCollections,
				hasError: state.collections.hasError
		};
}
export default connect(mapStateToProps, mapDispatchToProps)(Collections);
module.exports = connect(mapStateToProps, mapDispatchToProps)(Collections);