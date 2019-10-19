import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import styles from "../app/Styles";
import MonthlyList from "./monthly/MonthlyList";
import SnapshotList from "./snapshot/SnapshotList";

const propTypes = {};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class Budget extends React.Component {

	render() {
		const {classes} = this.props;
		return (
			<div className={classes.root}>
				<div>Wells Fargo Balance = $5_348_3.00</div>
				<MonthlyList/>
				<div className={classes.tableSpacer}/>
				<SnapshotList/>
			</div>
		);
	}
}

Budget.propTypes = propTypes;
Budget.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(Budget)));
