import React, {Component} from 'react';
import {Tabs, Tab} from 'material-ui/Tabs';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
const progress = require('nprogress');
// import {getVenueTags, updateVenueTagsStatus} from '../../../../actions';
import styles from '../../../../../../sass/components/panel/venues/Venue.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
import Tags from './Tags';

class Venue extends Component {
		render() {
				return (
						<div>
								<Tabs>
										<Tab label="اطلاعات">
												<h5>به زودی...</h5>
										</Tab>
										<Tab label="تگ">
												<Tags slug={this.props.params.slug}/>
										</Tab>
								</Tabs>
						</div>
				)
		}
}

function mapDispatchToProps(dispatch) {
		return bindActionCreators({}, dispatch);
}

function mapStateToProps(state) {
		return {
				isRequesting: state.venues.isRequesting,
				venueTags: state.venues.venueTags,
				hasVenueTags: state.venues.hasVenues,
				hasMessage: state.venues.hasMessage,
				message: state.venues.message,
		};
}
export default connect(mapStateToProps, mapDispatchToProps)(Venue);
module.exports = connect(mapStateToProps, mapDispatchToProps)(Venue);