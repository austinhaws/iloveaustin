import React from 'react';
import {Route, Switch} from 'react-router-dom';
import Pages from "./Pages";
import {connect} from "react-redux";
import * as PropTypes from "prop-types";
import Account from "./account/Account";

const propTypes = {
	app: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({app: state.app});

class AppRoutes extends React.Component {
	render() {
		return (
			Account.isSignedIn() ?
				<Switch>
					{Object.values(Pages.iLoveAustin).map(page => <Route key={page.path} path={page.path} component={page.component}/>)}
				</Switch>
			: Pages.iLoveAustin.home.component()
		);
	}
}

AppRoutes.propTypes = propTypes;
AppRoutes.defaultProps = defaultProps;

export default connect(mapStateToProps)(AppRoutes);
