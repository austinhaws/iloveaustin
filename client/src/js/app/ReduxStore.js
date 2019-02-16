import {createStore} from 'redux';
import reducers from './Reducers';
import {objectAtPath} from "dts-react-common";
import {dispatchUpdateData} from "./Shared";

export function dispatchDefaultState(paths) {
	_.castArray(paths).forEach(path => dispatchUpdateData({
		field: path,
		value: objectAtPath(defaultState, path)
	}));
}

export function getDefaultState(path) {
	return objectAtPath(defaultState, path);
}

const defaultState = {
	iLoveAustin: {
		snapshots: [],
	},
	app: {
		ajaxSpinnerCount: 0,
		postToken: undefined,
	},
};

const reduxStore = createStore((state, action) => {
		// === reducers ===
		let reducer = false;

		// is reducer valid?
		if (action.type in reducers) {
			reducer = reducers[action.type];
		}

		// ignore redux/react "system" reducers
		if (!reducer && action.type.indexOf('@@') !== 0) {
			console.error('unknown reducer action:', action.type, action);
		}

		// DO IT!
		return reducer ? reducer(state, action) : state;
	}, defaultState

	// for chrome redux plugin
	, window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
);

export default reduxStore;
