import React from 'react';
import {Component} from 'react';
import Menu from '../global/Menu';
const classNames = require('classnames/bind');
import {connect} from 'react-redux';

class Panel extends Component {
		render() {
				let isCreateCollection = this.props.children.type.displayName == 'Connect(ReduxForm)';
				if (this.props.isModal && isCreateCollection) {
						return (
								<div className="container">
										{this.props.children}
								</div>
						)
				}
				else
						return (
								<div>
										<div id="outer-container" style={{height: '100vh'}}>
												<Menu pageWrapId={'page-wrapper'} outerContainerId={'outer-container'}/>
												<main id="page-wrapper" style={{height: '100%',  marginRight: 20}}>
														<div className="container">
																{this.props.children}
														</div>
												</main>
										</div>
								</div>
						);
		}
}

function mapStateToProps(state) {
		return {
				isModal: state.modals.isModal,
		};
}

export default connect(mapStateToProps)(Panel);
module.exports = connect(mapStateToProps)(Panel);