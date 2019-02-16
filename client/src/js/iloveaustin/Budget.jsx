import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import webservice from "../app/Webservice";
import green from '@material-ui/core/colors/green';
import Paper from "@material-ui/core/Paper";
import Table from "@material-ui/core/Table";
import TableHead from "@material-ui/core/TableHead";
import TableRow from "@material-ui/core/TableRow";
import TableCell from "@material-ui/core/TableCell";
import TableBody from "@material-ui/core/TableBody";
import {fromDollarString, toDollarString} from "../app/Money";
import TableFooter from "@material-ui/core/TableFooter";
import Button from "@material-ui/core/Button";
import DeleteIcon from '@material-ui/icons/Delete';
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";
import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import Checkbox from "@material-ui/core/Checkbox";
import FormControlLabel from "@material-ui/core/FormControlLabel";

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
	addButton: {
		margin: '0 auto',
		borderColor: '#64991e',
		color: '#64991e',
		marginBottom: '10px',
	},
	bodyTableRow: {
		cursor: 'pointer',
	},
	formControl: {
		margin: theme.spacing.unit,
		minWidth: 120,
	},
	sectionTitle: {
		textAlign: 'center',
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

	constructor(props) {
		super(props);

		this.state = {
			editSnapshot: undefined,
		};
	}

	componentDidMount() {
		webservice.iLoveAustin.snapshot.list();
	};

	deleteSnapshot = snapshot => {
		if (confirm(`Are you sure you want to delete this snapshot "${snapshot.name}"?`)) {
			webservice.iLoveAustin.snapshot.delete(snapshot.id)
				.then(() => webservice.iLoveAustin.snapshot.list());
		}
	};

	editSnapshot = snapshot => {
		const editedSnapshot = { ...snapshot };
		// use strings for editor
		editedSnapshot.amt_goal = toDollarString(editedSnapshot.amt_goal);
		editedSnapshot.amt_current = toDollarString(editedSnapshot.amt_current);

		this.setState({ editSnapshot: editedSnapshot });
	};

	newSnapshot = () => {
		this.setState({
			editSnapshot: {
				id: undefined,
					name: '',
				amt_goal: 0,
				amt_current: 0,
				notes: '',
				is_totalable: 0,
			}
		});
	};

	saveEditSnapshot = () => {
		// convert $ strings to amount ints
		const saveSnapshot = { ...this.state.editSnapshot };
		saveSnapshot.amt_goal = fromDollarString(saveSnapshot.amt_goal);
		saveSnapshot.amt_current = fromDollarString(saveSnapshot.amt_current);
		saveSnapshot.amt_current += fromDollarString(saveSnapshot.add_current);

		webservice.iLoveAustin.snapshot.save(saveSnapshot)
			.then(() => this.setState({ editSnapshot: undefined }))
			.then(() => webservice.iLoveAustin.snapshot.list());
	};

	render() {
		if (!this.props.iLoveAustin.snapshots) {
			return null;
		}

		const {classes} = this.props;
		return (
			<div className={classes.root}>
				month picker and arrows
				Wells Fargo Balance = $5892.00
				add new monthly
				monthlies table
				name, goal, spent, left, weeks remaining, weekly allotment, delete
				totals: goal, spent, left


				<h3 className={classes.sectionTitle}>Snapshots</h3>
				<Button variant="outlined" className={classes.addButton} onClick={this.newSnapshot}>Add New Snapshot</Button>

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
								<TableRow
									className={classes.bodyTableRow}
									key={snapshot.id}
									onClick={() => this.editSnapshot(snapshot)}
								>
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
								<TableCell align="right">Totals:</TableCell>
								<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.snapshotsTotals.goal)}</b></TableCell>
								<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.snapshotsTotals.current)}</b></TableCell>
								<TableCell/>
							</TableRow>
							<TableRow>
								<TableCell align="right">No Wells Fargo Totals:</TableCell>
								<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.snapshotsTotalsNoWells.goal)}</b></TableCell>
								<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.snapshotsTotalsNoWells.current)}</b></TableCell>
								<TableCell/>
							</TableRow>
						</TableFooter>
					</Table>
				</Paper>

				{this.state.editSnapshot && (
					<Dialog
						open={!!this.state.editSnapshot}
						onClose={() => this.setState({ editSnapshot: undefined })}
						aria-labelledby="form-dialog-title"
					>
						<DialogTitle id="form-dialog-title">Edit Snapshot</DialogTitle>
						<DialogContent>
							<TextField
								autoFocus
								margin="dense"
								id="name"
								label="Name"
								fullWidth
								value={this.state.editSnapshot.name}
								onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, name: e.target.value }})}
							/>
							<FormControlLabel
								control={
									<Checkbox
										margin="dense"
										id="isWellsFargo"
										checked={this.state.editSnapshot.is_totalable === 1}
										onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, is_totalable: e.target.checked ? 1 : 0}})}
									/>
								}
								label="Does this add to the Well's Fargo total?"
							/>
							<TextField
								margin="dense"
								id="goal"
								label="Goal"
								fullWidth
								value={this.state.editSnapshot.amt_goal}
								onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, amt_goal: e.target.value }})}
							/>
							<TextField
								margin="dense"
								id="current"
								label="Current"
								fullWidth
								value={this.state.editSnapshot.amt_current}
								onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, amt_current: e.target.value }})}
							/>
							<TextField
								margin="dense"
								id="current"
								label="Add to Current"
								fullWidth
								value={this.state.editSnapshot.add_current === undefined ? "$0.00" : this.state.editSnapshot.add_current}
								onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, add_current: e.target.value }})}
							/>
							<TextField
								margin="dense"
								id="notes"
								label="Notes"
								fullWidth
								value={this.state.editSnapshot.notes}
								onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, notes: e.target.value }})}
								multiline={true}
							/>
						</DialogContent>
						<DialogActions>
							<Button onClick={() => this.setState({ editSnapshot: undefined })} color="primary">
								Cancel
							</Button>
							<Button onClick={this.saveEditSnapshot} color="primary">
								Save
							</Button>
						</DialogActions>
					</Dialog>
				)}
			</div>
		);
	}
}

Budget.propTypes = propTypes;
Budget.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(Budget)));
