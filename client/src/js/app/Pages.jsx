import React from "react";
import Budget from "../iloveaustin/Budget";
import History from "../app/history/History";
import Home from "../iloveaustin/Home";
import Savings from "../iloveaustin/Savings";

export default {
	iLoveAustin: {
		budget: {
			path: '/budget',
			component: () => <Budget/>,
			forward: History.forward(`/budget`),
		},

		savings: {
			path: '/savings',
			component: () => <Savings/>,
			forward: History.forward(`/savings`),
		},

		home: {
			path: '/',
			component: () => <Home/>,
			forward: History.forward(`/`),
		},
	},
};
