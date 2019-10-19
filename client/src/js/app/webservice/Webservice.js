import {AjaxStatusCore, MessagePopupCore, objectAtPath, WebserviceCore} from "dts-react-common";
import store from "../ReduxStore";
import {createPathActionPayload, dispatchField, dispatchUpdates} from "../Dispatch";
import WEBSERVICE_AJAX_IDS from "./WebserviceAjaxIds";
import currentContext from "./WebserviceContext";
import GraphQLCore from "./graphQLCore";
import loginMutation from "./graphql/mutation/loginMutation";
import periodQuery from "./graphql/query/periodQuery";
import monthlyQuery from "./graphql/query/monthlyQuery";
import monthlyDeleteMutation from "./graphql/mutation/monthlyDeleteMutation";
import monthlySaveMutation from "./graphql/mutation/monthlySaveMutation";

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
	rawPromiseCallback: promise => promise.then(data => {
		const errors = objectAtPath(data, 'data.errors');
		if (errors) {
			const error = errors[0].message;
			if (error === 'Internal server error') {
				MessagePopupCore.addMessage({title: 'Signed Out', message: 'You have been signed out for inactivity. Please sign in and try again.'});
			} else {
				MessagePopupCore.addMessage({title: 'Webservice Communication Interruption', message: message});
			}
			throw message;
		}
		return data;
	}),
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
			delete: monthlyId => graphQlWebservice.mutation(monthlyDeleteMutation(monthlyId), WEBSERVICE_AJAX_IDS.I_LOVE_AUSTIN.MONTHLY_DELETE),
			list: period => graphQlWebservice.query(monthlyQuery(period), WEBSERVICE_AJAX_IDS.I_LOVE_AUSTIN.MONTHLY_LIST),
			save: monthly => graphQlWebservice.mutation(monthlySaveMutation(monthly), WEBSERVICE_AJAX_IDS.I_LOVE_AUSTIN.MONTHLY_SAVE)
				.then(result => result.data.saveMonthly),
		},

		period: {
			// month year can be blank to get current period
			get: (includeMonthlies, period) => graphQlWebservice.query(periodQuery(period, includeMonthlies))
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