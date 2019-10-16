import React from "react";
import Budget from "../iloveaustin/Budget";
import History from "../app/history/History";
import Home from "../iloveaustin/Home";

export default {
	iLoveAustin: {
		budget: {
			path: '/budget',
			component: () => <Budget/>,
			forward: () => History.get().push(`/budget`),
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
