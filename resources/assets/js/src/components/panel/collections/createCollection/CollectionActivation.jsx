import React, {Component} from 'react';
import Toggle from 'material-ui/Toggle';
export default class CollectionActivation extends Component {
		constructor(props) {
				super(props);
		}

		componentDidMount() {
				this.props.input.onChange(true);
		}

		render() {
				let onToggle = (event, toggled) => {
						this.props.onToggle(toggled);
						this.props.input.onChange(toggled);
				};
				return (
						<Toggle
								label="فعال"
								defaultToggled={this.props.default}
								name={this.props.name}
								id={this.props.id}
								onToggle={onToggle}
								labelStyle={{display: 'inline', width: 'auto', marginRight: 20}}
						/>
				)
		}
}