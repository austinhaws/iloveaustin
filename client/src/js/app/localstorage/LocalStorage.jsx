import LocalStorageKeys from "./LocalStorageKeys";

const storageItem = key => ({
	get: () => localStorage.getItem(key),
	set: value => localStorage.setItem(key, value),
	remove: () => localStorage.removeItem(key),
});

export default {
	foodWeeksRemaining: storageItem(LocalStorageKeys.FOOD_WEEKS_REMAINING),
	googleTokenId: storageItem(LocalStorageKeys.GOOGLE_TOKEN_ID),
	period: storageItem(LocalStorageKeys.CURRENT_PERIOD),
}
