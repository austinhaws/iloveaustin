import reduxStore, {dispatchDefaultState} from "../ReduxStore";
import webservice from "../webservice/Webservice";
import LocalStorage from "../localstorage/LocalStorage";
import {createPathActionPayload, dispatchUpdates} from "../Dispatch";

const Period = {
	/**
	 * return value may be null if no current period, but it'll fetch and update state in that case so eventually you will have a period
	 * @return {*|string}
	 */
	current: () => {
		let returnValue = LocalStorage.period.get();

		if (returnValue !== reduxStore.getState().iLoveAustin.periods) {
			if (returnValue) {
				// have a period, but it doesn't match store, so fetch details for this new period
				webservice.iLoveAustin.period.get(true, returnValue)
					.then(({monthlies, ...period}) =>
						dispatchUpdates([
							createPathActionPayload('iLoveAustin.periods', period),
							createPathActionPayload('iLoveAustin.monthlies.list', monthlies),
						])
					);
			} else {
				if (reduxStore.getState().iLoveAustin.periods) {
					dispatchDefaultState(['iLoveAustin.periods', 'iLoveAustin.monthlies.list']);
				}
				// don't have a period, so go to the current period
				webservice.iLoveAustin.period.get(false, undefined)
					.then(period => {
						LocalStorage.period.set(period.period);
						Period.current();
					});
			}
		}
		return returnValue;
	},

	moveToPeriod: newPeriod => {
		// update local storage to track last viewed period
		LocalStorage.period.set(newPeriod);
		// change state so it forces a reload of period data from localstorage
		dispatchDefaultState(['iLoveAustin.periods', 'iLoveAustin.monthlies.list']);
		// reload data using the newly set period
		Period.current();
	},
};

export default Period;
