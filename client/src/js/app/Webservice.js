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
		axiosErrorHandler(error, true);
		throw error;
	});

const webserviceCityGen = new WebserviceCore({
	baseUrl: `${globals.webserviceUrlBase}iloveaustin/`,
	ajaxStatusCore: ajaxStatus,
	rawPromiseCallback: rawPromiseCallback,
});

/**
 * An axios catch() error handler
 * Note: Will also need to import showMessage() & app store when used.
 * @param error - Error object from axios.
 * @param displayError {boolean} - show the error to the user?
 */
export const axiosErrorHandler = (error, displayError) => {
	alert('Ajax error');
	console.error(error);
	throw error;
};


export default {
	iloveaustin: {
		login: credentials => webserviceCityGen.post('login', credentials),
	},
};
