import reduxStore, {dispatchDefaultState} from "../ReduxStore";
import webservice from "../webservice/Webservice";
import LocalStorage from "../localstorage/LocalStorage";
import {createPathActionPayload, dispatchUpdates} from "../Dispatch";
import React from "react";
import Snapshot from "../snapshot/Snapshot";

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
					.then(data => {
						const {monthlies, ...period} = data.period;
						const snapshots = data.snapshots;
						dispatchUpdates([
							createPathActionPayload('iLoveAustin.periods', period),

							createPathActionPayload('iLoveAustin.monthlies.list', monthlies || []),
							createPathActionPayload('iLoveAustin.monthlies.totals', Period.totalMonthlies(monthlies)),

							createPathActionPayload('iLoveAustin.snapshots.list', snapshots || []),
							createPathActionPayload('iLoveAustin.snapshots.totals', Snapshot.totalSnapshots(snapshots)),
						]);
					});
			} else {
				if (reduxStore.getState().iLoveAustin.periods) {
					dispatchDefaultState(['iLoveAustin.periods', 'iLoveAustin.monthlies.list']);
				}
				// don't have a period, so go to the current period
				webservice.iLoveAustin.period.get(false, undefined)
					.then(data => {
						LocalStorage.period.set(data.period.period);
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

	totalMonthlies: monthlies => (monthlies || []).reduce((totals, monthly) => {
		const amountGoal = parseInt(monthly.amountGoal, 10) || 0;
		const amountSpent = parseInt(monthly.amountSpent, 10) || 0;
		totals.amountGoal += amountGoal;
		totals.amountSpent += amountSpent;
		totals.amountLeft += Math.max(0, amountGoal - amountSpent);
		return totals;
	}, {amountGoal: 0, amountSpent: 0, amountLeft: 0}),
};

export default Period;
