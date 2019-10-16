import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import styles from "../app/Styles";
import MonthlyList from "./monthly/MonthlyList";

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
				<MonthlyList/>
				Wells Fargo Balance = $5892.00
				add new monthly
				monthlies table
				name, goal, spent, left, weeks remaining, weekly allotment, delete
				totals: goal, spent, left

				{/*<Snapshot {...this.props} />*/}
			</div>
		);
	}
}

Budget.propTypes = propTypes;
Budget.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(Budget)));
