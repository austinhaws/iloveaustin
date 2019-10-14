import {AjaxStatusCore, WebserviceCore} from "dts-react-common";
import store from "../ReduxStore";
import {createPathActionPayload, dispatchField, dispatchUpdates} from "../Dispatch";
import WEBSERVICE_AJAX_IDS from "./WebserviceAjaxIds";
import currentContext from "./WebserviceContext";
import GraphQLCore from "./graphQLCore";
import loginMutation from "./graphql/mutation/loginMutation";
import periodQuery from "./graphql/query/periodQuery";
import monthlyQuery from "./graphql/query/monthlyQuery";

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


export const ajaxStatusCore = new AjaxStatusCore();
const graphQlWebservice = new GraphQLCore({
	graphQLUrl: currentContext,
	ajaxStatusCore: ajaxStatusCore,
	jsLogging: undefined,
	loadDefaultsCallback: defaults => defaults.headers.common['Authorization'] = store.getState().app.googleTokenId,
});


const postTokenData = () => ({ token: store.getState().app.postToken });

const webservice = {
	app: {
		googleLogin: googleResponse => graphQlWebservice.mutation(loginMutation(googleResponse), WEBSERVICE_AJAX_IDS.APP.GOOGLE_LOGIN)
			.then(response => {
				const account = response.data.login;
				dispatchField('app.account', account);
				dispatchField('app.googleTokenId', googleResponse.tokenId);
				return account;
			})
	},
	iLoveAustin: {
		monthly: {
			list: period => graphQlWebservice.query(monthlyQuery(period), WEBSERVICE_AJAX_IDS.I_LOVE_AUSTIN.MONTHLY)
				.then(response => dispatchField('iLoveAustin.monthly.list', response.data.monthlies)),
		},

		period: {
			// month year can be blank to get current period
			get: (includeMonthlies, month, year) => graphQlWebservice.query(periodQuery(month, year, includeMonthlies))
				.then(result => result.data.period),
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