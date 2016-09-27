import React, {Component}from 'react';
const progress = require('nprogress/nprogress.js');
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import {setIsModal} from '../actions';
require('../../../sass/shared/nprogress.scss');
import CreateCollectionModal from './panel/collections/CreateCollectionModal';
progress.configure({trickleRate: 0.06, trickleSpeed: 600, showSpinner: true});

class App extends Component {
		componentWillReceiveProps(nextProps) {
				const isModal = nextProps.location.key !== this.props.location.key &&
						nextProps.location.state &&
						nextProps.location.state.modal;
				if (isModal) {
						this.previousChildren = this.props.children;
						this.props.setIsModal(true);
				}
		}


		render() {
				let {location} = this.props;
				let modalWrapper = (
						location.state &&
						location.state.modal &&
						this.previousChildren
				);
				let Modal = CreateCollectionModal;
				switch (this.props.modalType) {
						case "CreateCollection":
								Modal = CreateCollectionModal;
								break;
				}
				return (
						<div className="farsi">
								{modalWrapper ?
										this.previousChildren :
										this.props.children
								}
								{(modalWrapper &&
								<Modal
										returnTo={location.state.returnTo}>
										{this.props.children}
								</Modal>)}
						</div>
				);
		}
}
function mapStateToProps(state) {
		return {
				modalType: state.modals.modalType
		};
}
function mapDispatchToProps(dispatch) {
		return bindActionCreators({setIsModal: setIsModal}, dispatch);
}

export default connect(mapStateToProps, mapDispatchToProps)(App);
module.exports = connect(mapStateToProps, mapDispatchToProps)(App);