import reduxStore, {dispatchDefaultState} from "../ReduxStore";
import webservice from "../webservice/Webservice";
import LocalStorage from "../localstorage/LocalStorage";
import {createPathActionPayload, dispatchField, dispatchUpdates} from "../Dispatch";
import Pages from "../Pages";
import Period from "../period/Period";

export default {
	current: () => reduxStore.getState().app.account,

	signIn: tokenId => webservice.app.googleLogin({tokenId})
		.then(() => {
			LocalStorage.googleTokenId.set(tokenId);
			dispatchField('app.googleTokenId', tokenId);
			Period.current();
		})
		.catch(() => {
			dispatchUpdates([
				createPathActionPayload('app.googleTokenId', undefined),
				createPathActionPayload('app.account', undefined),
			]);
			LocalStorage.googleTokenId.remove();
			Pages.iLoveAustin.home.forward();
		}),

	signOut: () => {
		LocalStorage.googleTokenId.remove();
		dispatchDefaultState(['app.account', 'app.googleTokenId']);
		Pages.iLoveAustin.home.forward();
	},

	isSignedIn: () => {
		console.log({
			token: !!reduxStore.getState().app.googleTokenId,
			account: !!reduxStore.getState().app.account,
		});
		return !!reduxStore.getState().app.googleTokenId && !!reduxStore.getState().app.account;
	},
}
