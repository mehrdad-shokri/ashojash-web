import {MODALS,MODAL_TYPE} from './types';
export function setIsModal(isModal = false) {
		return function(dispatch) {
				dispatch({
						type: MODALS,
						payload: isModal
				});
		}
}
export function setModalType(modalType) {
		return function(dispatch) {
				dispatch({
						type: MODAL_TYPE,
						payload: modalType
				});
		}
}