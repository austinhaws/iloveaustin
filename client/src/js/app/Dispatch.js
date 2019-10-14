import {objectAtPathReducer} from "dts-react-common";
import reducers from "../app/Reducers";
import store from "../app/ReduxStore";
import reducer from "./Reducers";

/**
 * Generic redux dispatcher
 * @param payload object
 * @param payload.path string Path to the field to modify
 * @param payload.field string Field that you need to modify
 * @param payload.value any Value of the field
 */
export const dispatchUpdateData = payload => store.dispatch({
	type: reducer.ACTION_TYPES.UPDATE_DATA,
	payload: payload
});

/**
 * export one or more object at path payloads
 * often used in correlation with createPathActionPayload
 *
 * @param payloads array|object
 */
export const dispatchUpdates = payloads => store.dispatch({ type: reducers.ACTION_TYPES.UPDATE_DATA, payload: payloads });

/**
 *
 * @param path string
 * @param value *
 * @return {{value: *} & {path: any, field: (*|string)}}
 */
export const createPathActionPayload = (path, value) => Object.assign({ value }, pathToParts(path));

/**
 * given a string representing a "." path, split it in to pieces
 *
 * @param path
 * @return {{path: any, field: (*|string)}}
 */
const pathToParts = path => {
	const parts = path.split('.');
	const partsPath = parts.length > 1 ? parts.slice(0, parts.length - 1).join('.') : undefined;
	return {
		path: partsPath,
		field: parts[parts.length - 1]
	};
};

/**
 * dispatch a path to an object, the field of that object, and the new value for that field
 *
 * @param objectPath can be blank/undefined
 * @param field
 * @param value
 */
const dispatchFieldChanged = (objectPath, field, value) => {
	store.dispatch({type: reducers.ACTION_TYPES.UPDATE_DATA, payload: {path: objectPath, field: field, value: value}});
};

/**
 * set a field in a path of an object
 *
 * @param object
 * @param fullPath
 * @param value
 * @return {{}}
 */
export const setObjectAtPath = (object, fullPath, value) => {
	const {path, field} = pathToParts(fullPath);
	return objectAtPathReducer(object, {path: path, field: field, value});
};

/**
 * create function that will take a value and dispatch it to the given path
 *
 * @param path
 * @return {function(*=): void}
 */
export const dispatchFieldCurry = path => value => dispatchField(path, value);

/**
 * dispatch a change at a path to a value; uses pathToParts to make it a simple path call instead of 2 parameter path.field
 *
 * @param fullPath
 * @param value
 */
export const dispatchField = (fullPath, value) => {
	const {path, field} = pathToParts(fullPath);
	dispatchFieldChanged(path, field, (value && value.target) ? value.target.value : value);
};
