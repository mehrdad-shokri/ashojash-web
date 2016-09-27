import React, {Component} from 'react';
import SelectField from 'material-ui/SelectField';
import MenuItem from 'material-ui/MenuItem';
export default class CitySelect extends Component {
		constructor(props) {
				super(props);
				this.allCities = this.allCities.bind(this);
		}

		handleChange = (event, index, value) => {
				this.props.input.onChange(value);
				this.props.onChange(value);
		};

		render() {
				return (
						<div style={{marginBottom: 20}}>
								<SelectField
										id={this.props.id}
										value={this.props.city}
										floatingLabelText='شهر'
										name={this.props.name}
										errorText={this.props.meta.invalid && this.props.showError ? this.props.meta.error : ''}
										onChange={this.handleChange}
								>
										{this.allCities()}
								</SelectField>
						</div>

				)
		}

		allCities() {
				if (this.props.cities) {
						let items = this.props.cities.map(city=>
								<MenuItem key={city.slug} value={city.slug} primaryText={city.name}/>);
						return items;
				}

		}
}