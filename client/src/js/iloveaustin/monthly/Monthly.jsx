import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import MonthlyDatePicker from "./MonthlyDatePicker";
import Styles from "../../app/Styles";

const propTypes = {
	history: PropTypes.object.isRequired,
	month: PropTypes.string,
	year: PropTypes.string,
};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
	month: undefined,
	year: undefined,
});

class Monthly extends React.Component {


	// deleteSnapshot = snapshot => {
	// 	if (confirm(`Are you sure you want to delete this snapshot "${snapshot.name}"?`)) {
	// 		webservice.iLoveAustin.snapshot.delete(snapshot.id)
	// 			.then(() => webservice.iLoveAustin.snapshot.list());
	// 	}
	// };
	//
	// editSnapshot = snapshot => {
	// 	const editedSnapshot = { ...snapshot };
	// 	// use strings for editor
	// 	editedSnapshot.amt_goal = toDollarString(editedSnapshot.amt_goal);
	// 	editedSnapshot.amt_current = toDollarString(editedSnapshot.amt_current);
	//
	// 	this.setState({ editSnapshot: editedSnapshot });
	// };
	//
	// newSnapshot = () => {
	// 	this.setState({
	// 		editSnapshot: {
	// 			id: undefined,
	// 				name: '',
	// 			amt_goal: 0,
	// 			amt_current: 0,
	// 			notes: '',
	// 			is_totalable: 0,
	// 		}
	// 	});
	// };
	//
	// saveEditSnapshot = () => {
	// 	// convert $ strings to amount ints
	// 	const saveSnapshot = { ...this.state.editSnapshot };
	// 	saveSnapshot.amt_goal = fromDollarString(saveSnapshot.amt_goal);
	// 	saveSnapshot.amt_current = fromDollarString(saveSnapshot.amt_current);
	// 	saveSnapshot.amt_current += fromDollarString(saveSnapshot.add_current);
	//
	// 	webservice.iLoveAustin.snapshot.save(saveSnapshot)
	// 		.then(() => this.setState({ editSnapshot: undefined }))
	// 		.then(() => webservice.iLoveAustin.snapshot.list());
	// };

	render() {
		const {classes} = this.props;
		return (
			<div className={classes.root}>
				<MonthlyDatePicker/>

				{/*<h3 className={classes.sectionTitle}>*/}
					{/*Wells Fargo Balance = $5892.00*/}
				{/*</h3>*/}
				{/*<Button variant="outlined" className={classes.addButton} onClick={this.newSnapshot}>Add New Monthly</Button>*/}

				{/*<Paper className={classes.root}>*/}
					{/*<Table className={classes.table}>*/}
						{/*<TableHead>*/}
							{/*<TableRow>*/}
								{/*<TableCell>Name</TableCell>*/}
								{/*<TableCell align="right">Goal</TableCell>*/}
								{/*<TableCell align="right">Spent</TableCell>*/}
								{/*<TableCell align="right">Weeks Remaining</TableCell>*/}
								{/*<TableCell align="right">Weekly Allotment</TableCell>*/}
								{/*<TableCell/>*/}
							{/*</TableRow>*/}
						{/*</TableHead>*/}
						{/*<TableBody>*/}
							{/*{this.props.iLoveAustin.monthlies.list.map(monthly => (*/}
								{/*<TableRow*/}
									{/*className={classes.bodyTableRow}*/}
									{/*key={snapshot.id}*/}
									{/*onClick={() => this.editMonthly(monthly)}*/}
								{/*>*/}
									{/*<TableCell component="th" scope="row">{snapshot.name}</TableCell>*/}
									{/*<TableCell align="right">{toDollarString(snapshot.amt_goal)}</TableCell>*/}
									{/*<TableCell align="right">{toDollarString(snapshot.amt_current)}</TableCell>*/}
									{/*<TableCell align="right">*/}
										{/*<Button size="small" variant="contained" color="secondary" className={classes.button} onClick={() => this.deleteSnapshot(snapshot)}>*/}
											{/*<DeleteIcon fontSize="small" className={classes.rightIcon}/>*/}
										{/*</Button>*/}
									{/*</TableCell>*/}
								{/*</TableRow>*/}
							{/*))}*/}
						{/*</TableBody>*/}
						{/*<TableFooter>*/}
							{/*<TableRow>*/}
								{/*<TableCell align="right">Totals:</TableCell>*/}
								{/*<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.snapshotsTotals.goal)}</b></TableCell>*/}
								{/*<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.snapshotsTotals.current)}</b></TableCell>*/}
								{/*<TableCell/>*/}
							{/*</TableRow>*/}
							{/*<TableRow>*/}
								{/*<TableCell align="right">No Wells Fargo Totals:</TableCell>*/}
								{/*<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.snapshotsTotalsNoWells.goal)}</b></TableCell>*/}
								{/*<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.snapshotsTotalsNoWells.current)}</b></TableCell>*/}
								{/*<TableCell/>*/}
							{/*</TableRow>*/}
						{/*</TableFooter>*/}
					{/*</Table>*/}
				{/*</Paper>*/}

				{/*{this.state.editSnapshot && (*/}
					{/*<Dialog*/}
						{/*open={!!this.state.editSnapshot}*/}
						{/*onClose={() => this.setState({ editSnapshot: undefined })}*/}
						{/*aria-labelledby="form-dialog-title"*/}
					{/*>*/}
						{/*<DialogTitle id="form-dialog-title">Edit Snapshot</DialogTitle>*/}
						{/*<DialogContent>*/}
							{/*<TextField*/}
								{/*autoFocus*/}
								{/*margin="dense"*/}
								{/*id="name"*/}
								{/*label="Name"*/}
								{/*fullWidth*/}
								{/*value={this.state.editSnapshot.name}*/}
								{/*onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, name: e.target.value }})}*/}
							{/*/>*/}
							{/*<FormControlLabel*/}
								{/*control={*/}
									{/*<Checkbox*/}
										{/*margin="dense"*/}
										{/*id="isWellsFargo"*/}
										{/*checked={this.state.editSnapshot.is_totalable === 1}*/}
										{/*onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, is_totalable: e.target.checked ? 1 : 0}})}*/}
									{/*/>*/}
								{/*}*/}
								{/*label="Does this add to the Well's Fargo total?"*/}
							{/*/>*/}
							{/*<TextField*/}
								{/*margin="dense"*/}
								{/*id="goal"*/}
								{/*label="Goal"*/}
								{/*fullWidth*/}
								{/*value={this.state.editSnapshot.amt_goal}*/}
								{/*onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, amt_goal: e.target.value }})}*/}
							{/*/>*/}
							{/*<TextField*/}
								{/*margin="dense"*/}
								{/*id="current"*/}
								{/*label="Current"*/}
								{/*fullWidth*/}
								{/*value={this.state.editSnapshot.amt_current}*/}
								{/*onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, amt_current: e.target.value }})}*/}
							{/*/>*/}
							{/*<TextField*/}
								{/*margin="dense"*/}
								{/*id="current"*/}
								{/*label="Add to Current"*/}
								{/*fullWidth*/}
								{/*value={this.state.editSnapshot.add_current === undefined ? "$0.00" : this.state.editSnapshot.add_current}*/}
								{/*onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, add_current: e.target.value }})}*/}
							{/*/>*/}
							{/*<TextField*/}
								{/*margin="dense"*/}
								{/*id="notes"*/}
								{/*label="Notes"*/}
								{/*fullWidth*/}
								{/*value={this.state.editSnapshot.notes}*/}
								{/*onChange={e => this.setState({ editSnapshot: { ...this.state.editSnapshot, notes: e.target.value }})}*/}
								{/*multiline={true}*/}
							{/*/>*/}
						{/*</DialogContent>*/}
						{/*<DialogActions>*/}
							{/*<Button onClick={() => this.setState({ editSnapshot: undefined })} color="primary">*/}
								{/*Cancel*/}
							{/*</Button>*/}
							{/*<Button onClick={this.saveEditSnapshot} color="primary">*/}
								{/*Save*/}
							{/*</Button>*/}
						{/*</DialogActions>*/}
					{/*</Dialog>*/}
				{/*)}*/}
		{/*monthlies table*/}
		{/*name, goal, spent, left, weeks remaining, weekly allotment, delete*/}
			{/*totals: goal, spent, left*/}
			</div>


	);
	}
}

Monthly.propTypes = propTypes;
Monthly.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(Styles)(Monthly)));
