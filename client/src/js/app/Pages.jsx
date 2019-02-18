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
			path: '/budget/:month?/:year?',
			component: props => isLoggedIn() ? <Budget month={props.match.params.month} year={props.match.params.year}/> : <Login/>,
			forward: (history, month, year) => month ? history.push(`/budget/${month}/${year}`) : history.push(`/budget`),
		},

		savings: {
			path: '/savings',
			component: () => <Login/>,
			forward: history => history.push(`/savings`),
		},
	},
};
