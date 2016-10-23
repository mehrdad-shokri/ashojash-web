import React, {Component} from 'react';
import {Field, reduxForm} from 'redux-form';
import TagSelect from './TagSelect';

class AddTag extends Component {
		render() {
				return (
						<div>
								<TagSelect/>
								<input type="number"/>
						</div>
				)
		}
}
const validate = values => {
		const errors = {}
		if (!values.tag) {
				errors.login = 'ضروری'
		}
		if (!values.password) {
				errors.password = 'ضروری'
		}
		return errors
};
export default reduxForm({
		form: 'addTag',
		fields: ['name', 'weight'],
		validate
})(AddTag);