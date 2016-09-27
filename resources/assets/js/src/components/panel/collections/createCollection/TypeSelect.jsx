import React, {Component} from 'react';
import SelectField from 'material-ui/SelectField';
import MenuItem from 'material-ui/MenuItem';
export default class TypeSelect extends Component {
		constructor(props) {
				super(props);
				this.allTypes = this.allTypes.bind(this);
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
										value={this.props.type}
										floatingLabelText='نوع'
										name={this.props.name}
										onChange={this.handleChange}
										errorText={this.props.meta.invalid && this.props.showError ? this.props.meta.error : ''}
										>
										{this.allTypes()}
								</SelectField>
						</div>

				)
		}

		allTypes() {
				var options = [
						{value: 1, label: 'اسلاید کلکسیون'},
						{value: 2, label: 'لیست عمودی کلکسیون'},
						{value: 3, label: 'کلکسیون تکی'},
						{value: 4, label: 'اسلاید کسب و کار'},
						{value: 5, label: 'کسب و کار تکی بزرگ'},
						{value: 6, label: 'کسب و کار تکی متوسط'},
						{value: 7, label: 'لیست عمودی کسب و کار'},
				];
				return options.map(type=> {
						return <MenuItem key={type.value} value={type.value} primaryText={type.label}/>
				})
		}
}