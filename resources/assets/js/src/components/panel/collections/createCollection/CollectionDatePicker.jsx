import React, {Component, PropTypes} from 'react';
import DatePicker from 'material-ui/DatePicker';
import getMuiTheme from 'material-ui/styles/getMuiTheme';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
const moment = require('moment-jalaali');
moment.loadPersian();
require('moment/locale/fa');

export default class CollectionDatePicker extends Component {
		constructor(props) {
				super(props);
				this.onChange = this.onChange.bind(this);
		}

		onChange(event, param) {
				let fieldDatePicker = this.props.input;
				fieldDatePicker.onChange(param);
				if (this.props.onChange)
						this.props.onChange(param);
		}

		render() {
				let meta = this.props.meta;
				let hasError = meta.touched && meta.invalid;
				let theme = getMuiTheme(this.context.muiTheme, {
						isRtl: false,
				});
				let dateFormatter = (date) => {
						return moment(date).format('jYYYY/jM/jD');
				};
				return (
						<MuiThemeProvider muiTheme={theme}>
								<DatePicker hintText={this.props.hintText}
														DateTimeFormat={global.Intl.DateTimeFormat}
														mode="landscape"
														locale="fa-IR-u-ca-persian"
														okLabel={'خب'}
														id={this.props.id}
														formatDate={dateFormatter}
														cancelLabel={'بیخیال'}
														firstDayOfWeek={6}
														value={this.props.date}
														disabled={this.props.disabled}
														minDate={this.props.minDate}
														maxDate={this.props.maxDate}
														disableYearSelection={false}
														dialogContainerStyle={{direction: 'rtl'}}
														onChange={this.onChange}
														style={{display: 'inline-block', 'marginLeft': '20px'}}
								/>
						</MuiThemeProvider>

				)
		}
}

CollectionDatePicker.contextTypes = {
		muiTheme: PropTypes.object.isRequired,
};