import React, {Component} from 'react';
import {elastic as Menu} from 'react-burger-menu';
import {Link} from 'react-router';
import _ from 'lodash';
import Radium from 'radium';
let RadiumLink = Radium(Link);
import style from '../../../../sass/components/Menu.scss'
const classNames = require('classnames/bind');
const cx = classNames.bind(style);

const styles = {
		bmBurgerButton: {
				position: 'fixed',
				width: '36px',
				height: '30px',
				right: '36px',
				top: '36px'
		},
		bmMenuWrap: {
				direction: 'ltr',
				zIndex: 4,
		},
		bmBurgerBars: {
				background: '#373a47'
		},
		bmCrossButton: {
				height: '24px',
				width: '24px'
		},
		bmCross: {
				background: '#bdc3c7'
		},
		bmMenu: {
				background: '#373a47',
				padding: '2.5em 1.5em 0',
				fontSize: '1.15em',
				overflow: 'inherit'
		},
		bmMorphShape: {
				fill: '#373a47'
		},
		bmItemList: {
				color: '#b8b7ad',
				left: 0
		},
		bmOverlay: {
				background: 'rgba(0, 0, 0, 0.3)'
		},
};
class Burger extends Component {
		render() {
				return (
						<Menu styles={styles} right pageWrapId={this.props.pageWrapId}
									outerContainerId={this.props.outerContainerId} className="panelDrawer">
								{_.indexOf(this.props.permissions, 'manage-collection') > 0 ?
										<RadiumLink className={cx('menuItem')} to="/admin/panel/collections"
																activeClassName={cx('activeMenuItem')}>
												<i className={classNames('md')} style={{fontSize: 28}}>collections</i>
												<span style={{verticalAlign: 'top', fontSize: 22}}>کلکسیون</span></RadiumLink> : <span></span>}
								{_.indexOf(this.props.permissions, 'manage-tag') > 0 ?
										<RadiumLink className={cx('menuItem')} to="/admin/panel/tags"
																activeClassName={cx('activeMenuItem')}>
												<i className={classNames('md')} style={{fontSize: 28}}>class</i>
												<span style={{verticalAlign: 'top', fontSize: 22}}>رسته</span></RadiumLink> : <span></span>}
								{_.indexOf(this.props.permissions, 'manage-venue') > 0 ?
										<RadiumLink className={cx('menuItem')} to="/admin/panel/venues"
																activeClassName={cx('activeMenuItem')}>
												<i className={classNames('md')} style={{fontSize: 28}}>business</i>
												<span style={{verticalAlign: 'top', fontSize: 22}}>کسب و کار</span></RadiumLink> : <span></span>}

								<div className={cx('myLove')}>ساخته شده با <i className={cx("fa fa-heart", "heart")}></i> توسط
										مهرداد
								</div>
						</Menu>
				);
		}
}
module.exports = Burger;