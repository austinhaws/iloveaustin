import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import webservice, {ajaxStatus} from "../app/Webservice";
import green from '@material-ui/core/colors/green';
import {dispatchFieldCurry} from "../app/Dispatch";

const propTypes = {
	history: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

const styles = theme => ({
	root: {
		display: 'flex',
		flexWrap: 'wrap',
		flexDirection: 'column',
		width: '250px',
		margin: '0 auto',
	},
	formControl: {
		margin: theme.spacing.unit,
		minWidth: 120,
	},
	selectEmpty: {
		marginTop: theme.spacing.unit * 2,
	},
	buttonProgress: {
		color: green[500],
		position: 'absolute',
		top: '50%',
		left: '50%',
		marginTop: -12,
		marginLeft: -12,
	},
	slider: {
		padding: '22px 0px',
	},
});

class Budget extends React.Component {

	componentDidMount() {
		webservice.iLoveAustin.snapshot.list()
			.then(dispatchFieldCurry('iloveaustin.snapshots'));
	};

	render() {
		const { classes } = this.props;
		const ajaxing = ajaxStatus.isAjaxing();

		return (
			<div className={classes.root}>
				month picker and arrows
				Wells Fargo Balance = $5892.00
				add new monthly
				monthlies table
					name, goal, spent, left, weeks remaining, weekly allotment, delete
				totals: goal, spent, left


				snapshots
				add new snapshot
				snapshot table
					name, goal, current, delete
				totals row: goal, current
				No Wells Fargo Totals row: ???
			</div>
		);
	}
}

Budget.propTypes = propTypes;
Budget.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(Budget)));
