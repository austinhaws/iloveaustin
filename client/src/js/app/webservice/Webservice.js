import {AjaxStatusCore, MessagePopupCore, objectAtPath} from "dts-react-common";
import store from "../ReduxStore";
import {dispatchField} from "../Dispatch";
import WEBSERVICE_AJAX_IDS from "./WebserviceAjaxIds";
import currentContext from "./WebserviceContext";
import GraphQLCore from "./graphQLCore";
import loginMutation from "./graphql/mutation/loginMutation";
import periodQuery from "./graphql/query/periodQuery";
import monthlyQuery from "./graphql/query/monthlyQuery";
import monthlyDeleteMutation from "./graphql/mutation/monthlyDeleteMutation";
import monthlySaveMutation from "./graphql/mutation/monthlySaveMutation";
import spanshotDeleteMutation from "./graphql/mutation/spanshotDeleteMutation";
import snapshotSaveMutation from "./graphql/mutation/snapshotSaveMutation";

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
				.then(result => result.data),
		},

		snapshot: {
			delete: snapshotId => graphQlWebservice.mutation(spanshotDeleteMutation(snapshotId), WEBSERVICE_AJAX_IDS.I_LOVE_AUSTIN.SNAPSHOT_DELETE),
			save: snapshot => graphQlWebservice.mutation(snapshotSaveMutation(snapshot), WEBSERVICE_AJAX_IDS.I_LOVE_AUSTIN.SNAPSHOT_SAVE)
				.then(result => result.data.saveSnapshot),
		}
	},
};
export default webservice;
