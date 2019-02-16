import React from "react";
import Login from "../iloveaustin/Login";
import store from "./ReduxStore";
import Budget from "../iloveaustin/Budget";

function isLoggedIn() {
	return !!store.getState().app.postToken;
}

export default {
	iLoveAustin: {
		login: {
			path: '/',
			component: () => <Login/>,
			forward: history => history.push(`/`),
		},

		budget: {
			path: '/budget',
			component: () => isLoggedIn() ? <Budget/> : <Login/>,
			forward: history => history.push(`/budget`),
		},

		savings: {
			path: '/savings',
			component: () => <Login/>,
			forward: history => history.push(`/savings`),
		},
	},
};
