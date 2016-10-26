import React, {Component} from 'react';
import {Field, reduxForm} from 'redux-form';
import TagSelect from './TagSelect';
import styles from '../../../../../../sass/components/panel/venues/addTag.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
class AddTag extends Component {
		constructor(props) {
				super(props);
				this.handleFormSubmit = this.handleFormSubmit.bind(this);
		}

		render() {
				const {handleSubmit} = this.props;
				return (
						<div>
								<form action="post" onSubmit={handleSubmit(this.handleFormSubmit.bind(this))}
											className={cx('addTagForm')}>
										<Field name="tag" component={TagSelectField} slug={this.props.slug}/>
										<Field name="weight" component={WeightSelect}/>
										<button action="submit">اضافه کن</button>
										{this.renderAlert()}
								</form>
						</div>
				)
		}


		handleFormSubmit({tag, weight}) {
				this.props.handleFormSubmit(tag.name, weight);
				this.props.reset();
		}

		renderAlert() {
				if (this.props.isError) {
						return (
								<div className="formRow">
										{this.props.errorMessage}
								</div>
						);
				}
		}
}
const TagSelectField = (props)=> {
		let input = props.input;
		let meta = props.meta;
		let hasError = meta.invalid && meta.touched;
		return (
				<TagSelect input={input} slug={props.slug}/>
		)
}

const WeightSelect = (props)=> {
		let input = props.input;
		let meta = props.meta;
		let hasError = meta.invalid && meta.touched;
		return (
				<span>
						<input type="number" className={cx('weight')} {...input}/>
						{hasError ? <span>{meta.error}</span> : ''}
				</span>
		)
};
const validate = values => {
		const errors = {}
		if (!values.tag) {
				errors.tag = 'ضروری';
		}
		if (!values.weight) {
				errors.weight = 'ضروری';
		}
		else if (isNaN(values.weight)) {
				errors.weight = 'وزن باید مقدار عددی باشد.';
		}
		else {
				if (values.weight < 1)
						errors.weight = 'کمینه مقدار وزن 1 میباشد.';
				if (values.weight > 100)
						errors.weight = 'بیشینه مقدار وزن 100 میباشد.';
		}
		return errors;
};
export default reduxForm({
		form: 'addTag',
		fields: ['tag', 'weight'],
		validate
})(AddTag);