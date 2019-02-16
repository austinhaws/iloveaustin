import React from 'react';
import {Route, Switch} from 'react-router-dom';
import Pages from "./Pages";

class AppRoutes extends React.Component {
	render() {
		return (
			<Switch>
				<Route path={Pages.iLoveAustin.savings.path} component={Pages.iLoveAustin.savings.component}/>
				<Route path={Pages.iLoveAustin.budget.path} component={Pages.iLoveAustin.budget.component}/>
				<Route path={Pages.iLoveAustin.login.path} component={Pages.iLoveAustin.login.component}/>
			</Switch>
		);
	}
}

export default AppRoutes;
