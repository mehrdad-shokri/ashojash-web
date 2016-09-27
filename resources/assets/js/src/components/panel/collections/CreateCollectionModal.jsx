import React, {Component} from'react';
import Link from 'react-router/lib/Link'
import styles from '../../../../../sass/components/panel/collections/Modal.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);

export default class CreateCollectionModal extends Component {
		render() {
				return (
						<div className={cx('modalWrapper')}>
								<div className={cx('modalContent')}>
										{this.props.children}
								</div>
								<div className={cx('closeWrapper')}><Link to="/admin/panel/collections">
										<i className={cx('md', 'closeBtn')}>close</i></Link></div>
						</div>
				)
		}
}
module.exports = CreateCollectionModal;