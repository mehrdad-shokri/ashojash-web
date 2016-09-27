import React, {Component} from 'react';
import {elastic as Menu} from 'react-burger-menu';
import {Link} from 'react-router';
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
								<RadiumLink className={cx('menuItem')} to="/admin/panel/collections"
														activeClassName={cx('activeMenuItem')}>
										<i className={classNames('md')} style={{fontSize: 28}}>collections</i>
										<span style={{verticalAlign: 'top', fontSize: 22}}>کلسیون</span></RadiumLink>
								<div className={cx('myLove')}>ساخته شده با <i className={cx("fa fa-heart", "heart")}></i> توسط
										مهرداد
								</div>
						</Menu>
				);
		}
}
module.exports = Burger;