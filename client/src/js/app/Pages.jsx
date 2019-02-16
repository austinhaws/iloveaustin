import React from "react";
import Login from "../iloveaustin/Login";
import store from "./ReduxStore";

function isLoggedIn() {
	return !!store.getState().app.postToken;
}

export default {
	iLoveAustin: {
		login: {
			path: '/',
			component: () => isLoggedIn() ? <Login/> : <Login/>,
			forward: history => history.push(`/`),
		},

		budget: {
			path: '/budget',
			component: () => isLoggedIn() ? <Login/> : <Login/>,
			forward: history => history.push(`/budget`),
		},

		savings: {
			path: '/savings',
			component: () => <Login/>,
			forward: history => history.push(`/savings`),
		},
	},
};
