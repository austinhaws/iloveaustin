import LocalStorageKeys from "./LocalStorageKeys";

export default {
	googleTokenId: {
		get: () => localStorage.getItem(LocalStorageKeys.GOOGLE_TOKEN_ID),
		set: tokenId => localStorage.setItem(LocalStorageKeys.GOOGLE_TOKEN_ID, tokenId),
		remove: () => localStorage.removeItem(LocalStorageKeys.GOOGLE_TOKEN_ID),
	},
}