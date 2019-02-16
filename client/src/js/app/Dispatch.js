import {objectAtPathReducer} from "dts-react-common";
import store from "./ReduxStore";
import reducers from "./Reducers";


const pathToParts = path => {
	const parts = path.split('.');
	const partsPath = parts.length > 1 ? parts.slice(0, parts.length - 1).join('.') : undefined;
	return {
		path: partsPath,
		field: parts[parts.length - 1]
	};
};

const dispatchFieldChanged = (objectPath, field, value) => {
	store.dispatch({type: reducers.ACTION_TYPES.UPDATE_DATA, payload: {path: objectPath, field: field, value: value}});
};

export const setObjectAtPath = (object, fullPath, value) => {
	const { path, field } = pathToParts(fullPath);
	return objectAtPathReducer(object, { path: path, field: field, value });
};

export const dispatchFieldCurry = path => value => dispatchField(path, value);

export const dispatchField = (fullPath, value) => {
	const { path, field } = pathToParts(fullPath);
	dispatchFieldChanged(path, field, (value && value.target) ? value.target.value : value );
};

