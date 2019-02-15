import '@babel/polyfill';
import React from 'react';
import {render} from 'react-dom';
import {connect, Provider} from 'react-redux';
import reduxStore from '../util/ReduxStore';
import {BrowserRouter, withRouter} from 'react-router-dom';
import AppRoutes from './AppRoutes';
import CssBaseline from '@material-ui/core/CssBaseline';
import MainAppBar from "./MainAppBar";

class AppClass extends React.Component {
	render() {
		return (
			<React.Fragment>
				<CssBaseline/>

				<MainAppBar/>

				<AppRoutes {...this.props}/>
			</React.Fragment>
		);
	}
}

const App = withRouter(connect()(AppClass));


// This will correctly set the basename so router works, if you're using a awesome vhost or not.
const app = '/citygen';
const examplePos = window.location.pathname.indexOf(app);
const baseName = examplePos === -1 ? '/' : window.location.pathname.substr(0, examplePos + examples.length);
render(<BrowserRouter basename={baseName}><Provider store={reduxStore}><App/></Provider></BrowserRouter>, document.getElementById('react'));
