import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import webservice, {ajaxStatus} from "../app/Webservice";
import green from '@material-ui/core/colors/green';
import Paper from "@material-ui/core/Paper";
import Table from "@material-ui/core/Table";
import TableHead from "@material-ui/core/TableHead";
import TableRow from "@material-ui/core/TableRow";
import TableCell from "@material-ui/core/TableCell";
import TableBody from "@material-ui/core/TableBody";
import {toDollarString} from "../app/Money";
import TableFooter from "@material-ui/core/TableFooter";
import Button from "@material-ui/core/Button";
import DeleteIcon from '@material-ui/icons/Delete';

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
	table: {
		minWidth: 700,
	},
});

class Budget extends React.Component {

	componentDidMount() {
		webservice.iLoveAustin.snapshot.list();
	};

	deleteSnapshot = snapshot => {
		if (confirm(`Are you sure you want to delete this snapshot "${snapshot.name}"?`)) {
			webservice.iLoveAustin.snapshot.delete(snapshot.id);
		}
	};

	render() {
		if (!this.props.iLoveAustin.snapshots) {
			return null;
		}

		const {classes} = this.props;
		const ajaxing = ajaxStatus.isAjaxing();

		return (
			<div className={classes.root}>
				month picker and arrows
				Wells Fargo Balance = $5892.00
				add new monthly
				monthlies table
				name, goal, spent, left, weeks remaining, weekly allotment, delete
				totals: goal, spent, left


				<h3>Snapshots</h3>
				<a href="#">Add new snapshot</a>

				<Paper className={classes.root}>
					<Table className={classes.table}>
						<TableHead>
							<TableRow>
								<TableCell>Name</TableCell>
								<TableCell align="right">Goal</TableCell>
								<TableCell align="right">Current</TableCell>
								<TableCell/>
							</TableRow>
						</TableHead>
						<TableBody>
							{this.props.iLoveAustin.snapshots.map(snapshot => (
								<TableRow key={snapshot.id}>
									<TableCell component="th" scope="row">{snapshot.name}</TableCell>
									<TableCell align="right">{toDollarString(snapshot.amt_goal)}</TableCell>
									<TableCell align="right">{toDollarString(snapshot.amt_current)}</TableCell>
									<TableCell align="right">
										<Button size="small" variant="contained" color="secondary" className={classes.button} onClick={() => this.deleteSnapshot(snapshot)}>
											<DeleteIcon fontSize="small" className={classes.rightIcon}/>
										</Button>
									</TableCell>
								</TableRow>
							))}
						</TableBody>
						<TableFooter>
							<TableRow>
								<TableCell/>
								<TableCell align="right">{toDollarString(this.props.iLoveAustin.snapshotsTotals.goal)}</TableCell>
								<TableCell align="right">{toDollarString(this.props.iLoveAustin.snapshotsTotals.current)}</TableCell>
							</TableRow>
						</TableFooter>
					</Table>
				</Paper>


				No Wells Fargo Totals row: ???
			</div>
		);
	}
}

Budget.propTypes = propTypes;
Budget.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(Budget)));
