import React from "react";
import Budget from "../iloveaustin/Budget";
import History from "../app/history/History";
import Home from "../iloveaustin/Home";
import Savings from "../iloveaustin/Savings";

const basePath = '/iloveaustin';
// const basePath = '';

const addBasePath = path => `${basePath}${path}`;

export default {
	iLoveAustin: {
		budget: {
			path: addBasePath('/budget'),
			component: () => <Budget/>,
			forward: History.forward(addBasePath(`/budget`)),
		},

		savings: {
			path: addBasePath('/savings'),
			component: () => <Savings/>,
			forward: History.forward(addBasePath(`/savings`)),
		},

		home: {
			path: addBasePath('/'),
			component: () => <Home/>,
			forward: History.forward(addBasePath(`/`)),
		},
	},
};
