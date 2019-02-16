import React from 'react';
import {Route, Switch} from 'react-router-dom';
import Login from "../citygen/Login";

class AppRoutes extends React.Component {
	render() {
		return (
			<Switch>
				<Route path="/" component={Login}/>
			</Switch>
		);
	}
}

export default AppRoutes;
