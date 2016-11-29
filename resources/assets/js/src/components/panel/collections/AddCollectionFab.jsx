import React, {Component} from 'react';
import Link from 'react-router/lib/Link';
import styles from '../../../../../sass/components/panel/collections/fab/fab.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
export default class AddCollectionFab extends Component {
		render() {
				return (
						<div>
								<ul id="menu" className={cx('mfb-component--br')} data-mfb-toggle="hover">
										<li className={cx("mfb-component__wrap")}>
												<Link
														to={{
																pathname: '/admin/panel/collections/new',
																state: {modal: true, returnTo: this.props.pathname}
														}}
														className={cx("mfb-component__button--main")}>
														<i className={cx("mfb-component__main-icon--resting", "fa fa-plus")}></i>
														<i className={cx("mfb-component__main-icon--active", "fa fa-edit")}></i>
												</Link>
										</li>
								</ul>
						</div>
				)
		}
}