import React, {Component} from 'react';
import {Field, reduxForm} from 'redux-form';
import {bindActionCreators} from 'redux';
import {signinUser} from '../../actions'
import {connect} from 'react-redux'
import styles from '../../../../sass/components/auth/login.scss'
const classnames = require('classnames/bind');
const cx = classnames.bind(styles);
import LoginButton from './LoginButton';
const img = require('../../../../statics/img/auth/logo.png');
const progress = require('nprogress/nprogress.js');

class Login extends Component {
		static contextTypes = {
				router: React.PropTypes.object
		}

		constructor(props) {
				super(props);
				this.state = {
						isProcessing: false
				};
				this.handleFormSubmit = this.handleFormSubmit.bind(this);
		}

		handleFormSubmit({login, password}) {
				this.props.signinUser(login, password);
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


		render() {
				const {handleSubmit} = this.props;
				return (
						<div className={cx('login')}>
								<div className={cx('formContainer')}>
										<div className={cx('logo')}>
												<img src={img} alt=""/>
										</div>
										<div className={cx('form')}>
												<form action="post" onSubmit={handleSubmit(this.handleFormSubmit.bind(this))}>
														<Field name="login" component={LoginField}/>
														<Field name="password" component={PasswordField}/>
														{this.renderAlert()}
														<LoginButton action="submit" isProcessing={this.props.isSubmitting}
																				 isSuccess={this.props.authenticated} isError={this.props.isError}/>
												</form>
										</div>
								</div>
						</div>
				);
		}


		componentDidUpdate() {
				if (this.props.authenticated && this.props.token) {
						setTimeout(()=> {
								this.context.router.push('/admin/panel/collections');
						}, 400);
				}
		}

		componentWillUnmount() {
				progress.start();
		}

		componentDidMount() {
				progress.done();
		}
}
let LoginField = props=> {
		let login = props.input;
		let meta = props.meta;
		let hasLoginError = meta.invalid && meta.touched;
		return (
				<div className={cx('formRow', {'fieldError': hasLoginError})}>
						<svg viewBox="0 0 20 20" style={{width: '2rem', height: '2rem'}}>
								<path
										d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8"/>
						</svg>
						<input {...login} type="text" placeholder="نام کاربری یا ایمیل"/>
						{hasLoginError &&
						<div className={cx('fieldErrorMessage')}>{meta.error}</div>
						}
				</div>
		)
};
const PasswordField = (props)=> {
		let password = props.input;
		let meta = props.meta;
		let hasPasswordError = meta.touched && meta.invalid;
		return (
				<div className={cx('formRow', {'fieldError': hasPasswordError})}>
						<svg viewBox="0 0 20 20" style={{width: '2rem', height: '2rem'}}>
								<path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0"/>
						</svg>
						<input {...password} type="password" placeholder="پسورد"/>
						{hasPasswordError ?
								<div className={cx('fieldErrorMessage')}>{meta.error}</div> : ''}
				</div>
		)
};
function mapStateToProps(state) {
		return {
				isSubmitting: state.auth.isSubmitting,
				authenticated: state.auth.authenticated,
				isError: state.auth.isError,
				errorMessage: state.auth.errorMessage,
				token: state.auth.token
		};
}
function mapDispatchToProps(dispatch) {
		return bindActionCreators({signinUser: signinUser}, dispatch);
}
const validate = values => {
		const errors = {}
		if (!values.login) {
				errors.login = 'ضروری'
		}
		if (!values.password) {
				errors.password = 'ضروری'
		}
		return errors
};
module.exports = connect(mapStateToProps, mapDispatchToProps)(reduxForm({
		form: 'login',
		fields: ['login', 'password'],
		validate
})(Login));
