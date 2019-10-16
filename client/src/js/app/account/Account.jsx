import reduxStore, {dispatchDefaultState} from "../ReduxStore";
import webservice from "../webservice/Webservice";
import LocalStorage from "../localstorage/LocalStorage";
import {dispatchField} from "../Dispatch";
import Pages from "../Pages";
import Period from "../period/Period";

export default {
	current: () => reduxStore.getState().app.account,

	signIn: tokenId => webservice.app.googleLogin({tokenId})
			.then(() => {
				LocalStorage.googleTokenId.set(tokenId);
				dispatchField('app.googleTokenId', tokenId);
				Period.current();
			}),

	signOut: () => {
		LocalStorage.googleTokenId.remove();
		dispatchDefaultState(['app.account', 'app.googleTokenId']);
		Pages.iLoveAustin.home.forward();
	},

	isSignedIn: () => !!reduxStore.getState().app.googleTokenId,
}
