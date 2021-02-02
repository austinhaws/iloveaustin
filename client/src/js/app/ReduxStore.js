import {createStore} from 'redux';
import reducers from './Reducers';
import {objectAtPath, pathToParts} from "@dts-soldel/dts-react-common";
import {dispatchUpdateData} from "./Dispatch";

export function dispatchDefaultState(paths) {
	_.castArray(paths).forEach(path => dispatchUpdateData(Object.assign({ value:  objectAtPath(defaultState, path)}, pathToParts(path))));
}

export function getDefaultState(path) {
	return objectAtPath(defaultState, path);
}

const defaultState = {
	iLoveAustin: {
		monthlies: {
			list: undefined,
			totals: undefined,
		},
		periods: undefined,
		savings: {
			list: undefined,
			totals: undefined,
		},
		snapshots: {
			list: undefined,
			totals: undefined,
		},
	},
	app: {
		// account after logged in
		account: undefined,
		ajaxSpinnerCount: 0,
		historyPath: undefined,
		// token used for authentication
		googleTokenId: undefined,
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
