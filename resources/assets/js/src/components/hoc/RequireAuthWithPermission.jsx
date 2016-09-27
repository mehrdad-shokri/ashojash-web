import React, {Component} from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import {getPermissions, authenticateUser, refreshTokenIfNecessary} from '../../actions'
import _ from 'lodash';
import loaders from 'loaders.css/loaders.min.css';
import styles from '../../../../sass/components/Entry.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles, loaders);
const progress = require('nprogress/nprogress.js');
export default function requireAuthWithPermission(ComposedComponent, requiredPermissions) {
		class Authentication extends Component {
				static contextTypes = {
						router: React.PropTypes.object
				};

				componentDidUpdate() {
						this.validateUser();
				}

				componentDidMount() {
						this.validateUser();
						this.refreshTokenIfNecessary();
				}

				validateUser() {
						this.redirectIfUnauthenticated();
						this.redirectIfUnauthorized();
				}

				render() {
						if (this.isAuthorized() && this.isAuthenticated())
								return (
										<ComposedComponent {...this.props}></ComposedComponent>
								);
						else {
								return (
										<div className={cx('loaderContainer')}>
												<div className={cx('loader-inner', 'pacman', 'brand')}>
														<div></div>
														<div></div>
														<div></div>
														<div></div>
														<div></div>
												</div>
										</div>
								)

						}
				}

				redirectIfUnauthenticated() {
						if (!this.props.knowIfAuthenticated) {
								this.props.authenticateUser();
						}
						else if (!this.props.isAuthenticating && !this.props.authenticated) {
								this.context.router.push({
										pathname: '/admin/auth/login',
								});
						}
				}

				refreshTokenIfNecessary() {
						if (!this.props.isAuthenticating && this.props.authenticated) {
								this.props.refreshTokenIfNecessary()
						}
				}

				redirectIfUnauthorized() {
						if (!this.props.authenticated)
								return;
						if (!this.props.hasPermissions)
								this.props.getPermissions();
						else if (!this.props.isFetchingPermissions && !this.isAuthorized()) {
								this.context.router.push({
										pathname: '/admin/error',
										state: {message: 'شرمنده، مشکلی رخ داد.', status: 500}
								});
						}
				}

				isAuthenticated() {
						return this.props.authenticated;
				}

				isAuthorized() {
						if (this.props.hasPermissions)
								return _.difference(requiredPermissions, this.props.permissions).length === 0;
						return false;
				}
		}

		function mapDispatchToProps(dispatch) {
				return bindActionCreators({getPermissions, authenticateUser, refreshTokenIfNecessary}, dispatch);
		}

		function mapStateToProps(state) {
				return {
						isFetchingPermissions: state.auth.isFetchingPermissions,
						permissions: state.auth.permissions,
						hasPermissions: state.auth.hasPermissions,
						authenticated: state.auth.authenticated,
						knowIfAuthenticated: state.auth.knowIfAuthenticated,
						isAuthenticating: state.auth.isAuthenticating
				};
		}

		return connect(mapStateToProps, mapDispatchToProps)(Authentication);
}
module.exports = requireAuthWithPermission;
