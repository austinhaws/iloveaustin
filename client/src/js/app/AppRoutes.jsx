import React from 'react';
import {Route, Switch} from 'react-router-dom';
import Pages from "./Pages";

class AppRoutes extends React.Component {
	render() {
		return (
			<Switch>
				{Object.values(Pages.iLoveAustin).map(page => <Route key={page.path} path={page.path} component={page.component}/>)}
			</Switch>
		);
	}
}

export default AppRoutes;
