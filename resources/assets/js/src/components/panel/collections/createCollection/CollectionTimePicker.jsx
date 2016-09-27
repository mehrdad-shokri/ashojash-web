import React, {Component, PropTypes} from 'react';
import TimePicker from 'material-ui/TimePicker';
import getMuiTheme from 'material-ui/styles/getMuiTheme';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
const moment = require('moment-jalaali');
moment.loadPersian();
require('moment/locale/fa');

export default class CollectionTimePicker extends Component {
		constructor(props) {
				super(props);
				this.onChange = this.onChange.bind(this);
		}

		componentDidUpdate() {
				if (this.props.time)
						document.getElementById(this.props.id).value = moment(this.props.time).format('HH:mm')
		}

		componentDidMount() {
				if (this.props.time)
						document.getElementById(this.props.id).value = moment(this.props.time).format('HH:mm')
		}

		onChange(event, param) {
				let fieldTimePicker = this.props.input;
				fieldTimePicker.onChange(param);
				this.props.onChange(param);
		}

		render() {
				let meta = this.props.meta;
				let theme = getMuiTheme(this.context.muiTheme, {
						isRtl: false,
				});
				let dateFormatter = (date) => {
						return moment(date).format('jYYYY/jM/jD');
				};
				return (
						<MuiThemeProvider muiTheme={theme}>
								<TimePicker
										format="24hr"
										ref="timePicker"
										hintText={this.props.hintText}
										value={this.props.time}
										okLabel={'خب'}
										cancelLabel={'بیخیال'}
										disabled={this.props.disabled}
										onChange={this.onChange}
										id={this.props.id}
										style={{display: 'inline-block'}}
								/>
						</MuiThemeProvider>

				)
		}
}

CollectionTimePicker.contextTypes = {
		muiTheme: PropTypes.object.isRequired,
};