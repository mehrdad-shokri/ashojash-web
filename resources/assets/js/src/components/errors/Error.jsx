import React, {Component} from 'react';
const classNames = require('classnames/bind');
import styles from '../../../../sass/components/errors/Error.scss';
import Link from 'react-router/lib/Link'
const progress = require('nprogress/nprogress.js');
const cx = classNames.bind(styles);
class Error extends Component {
		render() {
				let {location:{state}}=this.props;
				var message, status;
				if (state !== null) {
						message = state.message;
						status = state.status;
				}
				const notFoundError = 'ببخشید، دیگه از اون نداریم.';
				message = message ? message : notFoundError;
				status = status ? status : 404;
				const imageType = (status === 404) ? 'empty-plate' : 'tragedy';
				const gone = (status !== 404);
				return (
						<div className={cx('error', imageType)}>
								<div>
										<div >
												<h1 className={cx('errorStatus')}>
														{status}
												</h1></div>
										<div className={cx('errorMessage')}>{message}</div>
										<div><Link to="/admin" className={cx('ghostButton', {gone})}>خونه</Link></div>
								</div>
						</div>
				)
		}

		componentDidMount() {
				progress.done();
		}

		componentWillUnmount() {
				progress.start();
		}
}
module.exports = Error;