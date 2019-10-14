import '@babel/polyfill';
import React from 'react';
import {render} from 'react-dom';
import {connect, Provider} from 'react-redux';
import reduxStore from '../app/ReduxStore';
import {BrowserRouter, withRouter} from 'react-router-dom';
import AppRoutes from './AppRoutes';
import CssBaseline from '@material-ui/core/CssBaseline';
import MainAppBar from "./MainAppBar";
import GoogleLogin from "react-google-login";
import webservice from "./Webservice";

class AppClass extends React.Component {
	responseGoogle = googleResponse => webservice.app.googleLogin(googleResponse)
			.then(() => alert('go to account home page after logging in'));

	render() {
		return (
			<React.Fragment>
				<CssBaseline/>

				<MainAppBar/>

				<GoogleLogin
					clientId="306725008311-l4rt8a9edu84ru378h285msmtmtgn9k1.apps.googleusercontent.com"
					buttonText="Sign In"
					onSuccess={this.responseGoogle}
					onFailure={this.responseGoogle}
					cookiePolicy={'single_host_origin'}
				/>
				<AppRoutes {...this.props}/>
			</React.Fragment>
		);
	}
}

const App = withRouter(connect()(AppClass));


// This will correctly set the basename so router works, if you're using an awesome vhost or not.
const app = '/iloveaustin3';
const examplePos = window.location.pathname.indexOf(app);
const baseName = examplePos === -1 ? '/' : window.location.pathname.substr(0, examplePos + app.length);
render(<BrowserRouter basename={baseName}><Provider store={reduxStore}><App/></Provider></BrowserRouter>, document.getElementById('react'));
