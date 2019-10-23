import LocalStorageKeys from "./LocalStorageKeys";
import reduxStore from "../ReduxStore";
import {MessagePopupCore, objectAtPath} from "dts-react-common";

const storageItem = (key, accountBased) => {
	// store keys with account prefix so that different users have different settings
	const accountKey = () => {
		const email = accountBased && objectAtPath(reduxStore.getState(), 'app.account.email');
		if (accountBased && !email) {
			// this is a programmer flow error!
			MessagePopupCore.addMessage({title: 'Missing Account', message: 'Email required for account based local storage keys'});
			console.error(`storage key: ${key}`);
			return undefined;
		}
		return [accountBased && email, key].filter(i => i).join('-');
	};

	return {
		get: defaultValue => localStorage.getItem(accountKey() || defaultValue),
		set: value => localStorage.setItem(accountKey(), value),
		remove: () => localStorage.removeItem(accountKey()),
	};
};

export default {
	foodWeeksRemaining: storageItem(LocalStorageKeys.FOOD_WEEKS_REMAINING, true),
	googleTokenId: storageItem(LocalStorageKeys.GOOGLE_TOKEN_ID, false),
	path: storageItem(LocalStorageKeys.HISTORY_PATH, true),
	period: storageItem(LocalStorageKeys.CURRENT_PERIOD, true),
}
