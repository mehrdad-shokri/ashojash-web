import React, {Component} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import {venueMessage, getVeneues} from '../../../actions'
const progress = require('nprogress');
import styles from '../../../../../sass/components/panel/venues/Venues.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
import {
		Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn
}    from 'material-ui/Table';
import Snackbar from 'material-ui/Snackbar';

class Venues extends Component {
		render() {
				return (

				)
		}
}

function mapDispatchToProps(dispatch) {
		return bindActionCreators({
				getVenues: getVeneues,
				venueMessage: venueMessage,
		}, dispatch);
}

function mapStateToProps(state) {
		return {
				isRequesting: state.tags.isRequesting,
				venues: state.venues.venues,
				hasVenues: state.tags.hasVenues,
				hasMessage: state.tags.hasMessage,
				message: state.tags.message,
		};
}
export default connect(mapStateToProps, mapDispatchToProps)(Venues);
module.exports = connect(mapStateToProps, mapDispatchToProps)(Venues);