import reduxStore from "../ReduxStore";
import webservice from "../webservice/Webservice";
import LocalStorage from "../localstorage/LocalStorage";
import {createPathActionPayload, dispatchUpdates} from "../Dispatch";
import Pages from "../Pages";

export default {
	current: () => reduxStore.getState().app.account,

	signIn: tokenId => webservice.app.googleLogin({tokenId})
			.then(() => LocalStorage.googleTokenId.set(tokenId)),

	signOut: () => {
		LocalStorage.googleTokenId.remove();
		dispatchUpdates([
			createPathActionPayload('app.account', undefined),
			createPathActionPayload('app.googleTokenId', undefined)
		]);
		Pages.iLoveAustin.home.forward();
	},

	isSignedIn: () => !!reduxStore.getState().app.googleTokenId,
}