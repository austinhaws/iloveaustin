import '@babel/polyfill';
import React from 'react';
import {render} from 'react-dom';
import {connect, Provider} from 'react-redux';
import reduxStore from '../app/ReduxStore';
import {BrowserRouter, withRouter} from 'react-router-dom';
import AppRoutes from './AppRoutes';
import CssBaseline from '@material-ui/core/CssBaseline';
import MainAppBar from "./MainAppBar";
import History from '../app/history/History';
import * as PropTypes from "prop-types";
import {MessagePopupCore} from "@dts-soldel/dts-react-common";
import "../../css/index.scss";
import {withStyles} from "@material-ui/core";
import styles from "../app/Styles";

const propTypes = {
	classes: PropTypes.object.isRequired,
	history: PropTypes.object.isRequired,
};
const defaultProps = {
};
const mapStateToProps = state => ({});

class AppClass extends React.Component {

	componentDidMount() {
		if (!this.props.history) {
			console.error("history does not exist for app");
		}
		History.set(this.props.history);
	}

	render() {
		return (
			<React.Fragment>
				<CssBaseline/>

				<MainAppBar/>
				<div className={this.props.classes.navBarSpacer}/>
				<AppRoutes/>
				<MessagePopupCore/>
			</React.Fragment>
		);
	}
}

AppClass.propTypes = propTypes;
AppClass.defaultProps = defaultProps;

const App = withRouter(connect(mapStateToProps)(withStyles(styles)(AppClass)));

// This will correctly set the basename so router works
const app = '/';
const examplePos = window.location.pathname.indexOf(app);
const baseName = examplePos === -1 ? '/' : window.location.pathname.substr(0, examplePos + app.length);
render(<BrowserRouter basename={baseName}><Provider store={reduxStore}><App/></Provider></BrowserRouter>, document.getElementById('react'));
