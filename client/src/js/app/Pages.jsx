import React from "react";
import store from "./ReduxStore";
import Budget from "../iloveaustin/Budget";
import Home from "../iloveaustin/Home";

function isLoggedIn() {
	return !!store.getState().app.account;
}

export default {
	iLoveAustin: {
		budget: {
			path: '/budget/:month?/:year?',
			component: props => isLoggedIn() ? <Budget month={props.match.params.month} year={props.match.params.year}/> : <Home/>,
			forward: (history, month, year) => month ? history.push(`/budget/${month}/${year}`) : history.push(`/budget`),
		},

		savings: {
			path: '/savings',
			component: () => <Home/>,
			forward: history => history.push(`/savings`),
		},

		home: {
			path: '/',
			component: () => <Home/>,
			forward: history => history.push(`/`),
		},
	},
};
