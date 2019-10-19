import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import styles from "../app/Styles";
import MonthlyList from "./monthly/MonthlyList";
import SnapshotList from "./snapshot/SnapshotList";
import {addPlainMoney, toDirtyMoney} from "../app/money/Money";

const propTypes = {};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class Budget extends React.Component {

	totalBankBudget = () =>
		toDirtyMoney(
			addPlainMoney(
				(this.props.iLoveAustin.monthlies.list || []).reduce((total, monthly) => addPlainMoney(total, monthly.amountGoal), undefined),
				(this.props.iLoveAustin.snapshots.list || []).reduce((total, snapshot) => addPlainMoney(total, snapshot.amountCurrent), undefined)
			)
		);

	render() {
		const {classes} = this.props;
		return (
			<div className={classes.root}>
				<div className={classes.bankBalanceTitle}>Bank Balance = {this.totalBankBudget()}</div>
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
