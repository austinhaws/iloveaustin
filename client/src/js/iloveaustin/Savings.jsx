import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import styles from "../app/Styles";
import {addPlainMoney, toDirtyMoney} from "../app/money/Money";
import SavingsList from "./savings/SavingsList";

const propTypes = {};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class Savings extends React.Component {

	totalBankSavings = () =>
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
				<SavingsList/>
			</div>
		);
	}
}

Savings.propTypes = propTypes;
Savings.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(Savings)));
