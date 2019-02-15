import store from './ReduxStore';
import reducer from './Reducers';

/**
 * Generic redux dispatcher
 * @param payload object
 * @param payload.path string Path to the field to modify
 * @param payload.field string Field that you need to modify
 * @param payload.value any Value of the field
 */
export function dispatchUpdateData(payload) {
	store.dispatch({
		type: reducer.ACTION_TYPES.UPDATE_DATA,
		payload: payload
	});
}
