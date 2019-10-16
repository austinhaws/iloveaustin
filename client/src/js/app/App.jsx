import '@babel/polyfill';
import React from 'react';
import {render} from 'react-dom';
import {connect, Provider} from 'react-redux';
import reduxStore from '../app/ReduxStore';
import {BrowserRouter, withRouter} from 'react-router-dom';
import AppRoutes from './AppRoutes';
import CssBaseline from '@material-ui/core/CssBaseline';
import MainAppBar from "./MainAppBar";
import History from './history/History';
import * as PropTypes from "prop-types";
import webservice from "./webservice/Webservice";
import {dispatchFieldCurry} from "./Dispatch";

const propTypes = {
	history: PropTypes.object.isRequired,
	periods: PropTypes.object,
};
const defaultProps = {
	periods: undefined,
};

class AppClass extends React.Component {

	componentDidMount() {
		if (!this.props.history) {
			console.error("history does not exist for app");
		}
		History.set(this.props.history);

		webservice.iLoveAustin.period.get(false, undefined, undefined)
			.then(dispatchFieldCurry('iLoveAustin.periods'));
	}

	render() {
		return (
			<React.Fragment>
				<CssBaseline/>

				<MainAppBar/>

				{this.props.periods ? <AppRoutes {...this.props}/> : undefined}
			</React.Fragment>
		);
	}
}

AppClass.propTypes = propTypes;
AppClass.defaultProps = defaultProps;

const App = withRouter(connect()(AppClass));


// This will correctly set the basename so router works, if you're using an awesome vhost or not.
const app = '/';
const examplePos = window.location.pathname.indexOf(app);
const baseName = examplePos === -1 ? '/' : window.location.pathname.substr(0, examplePos + app.length);
render(<BrowserRouter basename={baseName}><Provider store={reduxStore}><App/></Provider></BrowserRouter>, document.getElementById('react'));
