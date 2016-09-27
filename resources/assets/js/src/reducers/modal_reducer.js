import {
		MODALS,
		MODAL_TYPE
} from '../actions/types';
import {createReducer} from '../utils/utils';
const initialState = {
		isModal: false,
		modalType: null
};

export default createReducer(initialState, {
		[MODALS]: (state, payload)=> {
				return {...state, isModal: payload}
		},
		[MODAL_TYPE]: (state, payload)=> {
				return {...state, modalType: payload}
		}
});
