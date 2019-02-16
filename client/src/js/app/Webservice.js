import {AjaxStatusCore, WebserviceCore} from "dts-react-common";
import store from "./ReduxStore";
import {dispatchField} from "./Dispatch";

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

export default {
	iLoveAustin: {
		login: credentials => webserviceILoveAustin.post('login', credentials),
		snapshot: {
			list: () => webserviceILoveAustin.post('snapshot/list', {token: store.getState().app.postToken}),
		}
	},
};
