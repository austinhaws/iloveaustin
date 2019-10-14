import React from "react";
import Budget from "../iloveaustin/Budget";
import History from "../app/history/History";
import Home from "../iloveaustin/Home";
import store from "./ReduxStore";

function isLoggedIn() {
	return !!store.getState().app.account;
}

export default {
	iLoveAustin: {
		budget: {
			path: '/budget/:month?/:year?',
			component: props => isLoggedIn() ? <Budget month={props.match.params.month} year={props.match.params.year}/> : <Home/>,
			forward: (month, year) => month ? History.get().push(`/budget/${month}/${year}`) : History.get().push(`/budget`),
		},

		savings: {
			path: '/savings',
			component: () => <Home/>,
			forward: () => History.get().push(`/savings`),
		},

		home: {
			path: '/',
			component: () => <Home/>,
			forward: () => History.get().push(`/`),
		},
	},
};
