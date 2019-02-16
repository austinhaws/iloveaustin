import {objectAtPathReducer} from 'dts-react-common';

let reducers = {
	ACTION_TYPES: {
		// App
		UPDATE_DATA: 'UPDATE_DATA',
	}
};

/* ---- Generic Reducer --------------------------------------------------------------------------------------
	payload single: {path: 'path.to.object', field: 'fieldInObject', value: 'new value of the field'}
	payload array: [ {path: 'path.to.object', field: 'fieldInObject', value: 'new value of the field'}, ... ]
   ----------------------------------------------------------------------------------------------------------- */
reducers[reducers.ACTION_TYPES.UPDATE_DATA] = objectAtPathReducer;

export default reducers;
