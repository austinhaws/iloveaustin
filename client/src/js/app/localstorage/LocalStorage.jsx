import LocalStorageKeys from "./LocalStorageKeys";

const storageItem = key => ({
	get: () => {
		const result = localStorage.getItem(key);
		console.log('localstorage', {[key]: result});
		return result;
	},
	set: value => localStorage.setItem(key, value),
	remove: () => localStorage.removeItem(key),
});

export default {
	googleTokenId: storageItem(LocalStorageKeys.GOOGLE_TOKEN_ID),
	period: storageItem(LocalStorageKeys.CURRENT_PERIOD),
}