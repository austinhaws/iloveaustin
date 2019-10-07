import {AjaxStatusCore, WebserviceCore} from "dts-react-common";
import store from "./ReduxStore";
import {createPathActionPayload, dispatchField, dispatchFieldCurry, dispatchUpdates} from "./Dispatch";

export const ajaxStatus = new AjaxStatusCore();
ajaxStatus.registerChangedCallback(
	(ajaxId, isAjaxingStarting) => dispatchField('app.ajaxSpinnerCount', store.getState().app.ajaxSpinnerCount + (isAjaxingStarting ? 1 : -1))
);

const rawPromiseCallback = promise => promise
	.then(function (response) {
		if (response.status !== 200) {
			throw response;
		}
		return response;
	})
	.catch(error => {
		console.error(error);
		return error;
	});

const webserviceILoveAustin = new WebserviceCore({
	baseUrl: `${globals.webserviceUrlBase}iloveaustin/`,
	ajaxStatusCore: ajaxStatus,
	rawPromiseCallback: rawPromiseCallback,
});

const postTokenData = () => ({ token: store.getState().app.postToken });

const webservice = {
	iLoveAustin: {
		login: credentials => webserviceILoveAustin.post('login', credentials),

		monthly: {
			list: period => webserviceILoveAustin.post(`monthly/list/${period.month}/${period.year}`, { ...postTokenData(), period })
				.then(list => dispatchField('iLoveAustin.monthly.list', list)),
		},

		period: {
			get: (month, year) => webserviceILoveAustin.get(month ? `period/get/${month || ''}/${year || ''}` : `period/get`)
				.then(dispatchFieldCurry('iLoveAustin.periods')),
		},

		snapshot: {
			delete: snapshotId => webserviceILoveAustin.post(`snapshot/delete`, { snapshotId, ...postTokenData() }),
			list: () => webserviceILoveAustin.post('snapshot/list', postTokenData())
				.then(list => {
					list.sort((a, b) => a.name.localeCompare(b.name));
					list.forEach(snapshot => {
						snapshot.amt_goal = Number(snapshot.amt_goal);
						snapshot.amt_current = Number(snapshot.amt_current);
					});

					dispatchUpdates([
						createPathActionPayload('iLoveAustin.snapshots', list),
						createPathActionPayload('iLoveAustin.snapshotsTotals', list.reduce((carry, snapshot) => {
							carry.goal += snapshot.amt_goal;
							carry.current += snapshot.amt_current;
							return carry;
						}, { goal: 0, current: 0 })),
						createPathActionPayload('iLoveAustin.snapshotsTotalsNoWells', list.filter(snapshot => snapshot.is_totalable === 0)
							.reduce((carry, snapshot) => {
								carry.goal += snapshot.amt_goal;
								carry.current += snapshot.amt_current;
								return carry;
							}, { goal: 0, current: 0 })
						),
					]);
				}),
			save: snapshot => webserviceILoveAustin.post(`snapshot/save`, { ...snapshot, ...postTokenData() }),
		}
	},
};
export default webservice;