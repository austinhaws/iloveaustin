import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {Grid, IconButton, Popover, Toolbar, Tooltip, Typography, withStyles} from "@material-ui/core";
import Paper from "@material-ui/core/Paper";
import Table from "@material-ui/core/Table";
import TableHead from "@material-ui/core/TableHead";
import TableRow from "@material-ui/core/TableRow";
import TableCell from "@material-ui/core/TableCell";
import TableBody from "@material-ui/core/TableBody";
import {toDollarString} from "../../app/money/Money";
import TableFooter from "@material-ui/core/TableFooter";
import Button from "@material-ui/core/Button";
import DeleteIcon from '@material-ui/icons/Delete';
import MessageIcon from '@material-ui/icons/Message';
import styles from "../../app/Styles";
import {handleEvent, joinClassNames} from "dts-react-common";
import MonthlyDatePicker from "./MonthlyDatePicker";
import LocalStorage from "../../app/localstorage/LocalStorage";
import webservice from "../../app/webservice/Webservice";
import {createPathActionPayload, dispatchField, dispatchUpdates} from "../../app/Dispatch";
import AddCircleIcon from '@material-ui/icons/AddCircle';
import MonthlyEdit from "./MonthlyEdit";
import Period from "../../app/period/Period";

const propTypes = {};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class MonthlyList extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			foodWeeksRemaining: LocalStorage.foodWeeksRemaining.get() || 0,
			deletingId: undefined,
			editingMonthly: undefined,
			popOverDetail: undefined,
		};
	}

	foodWeeksRemainingChange = e => {
		const newValue = parseInt(e.target.value, 10);
		LocalStorage.foodWeeksRemaining.set(newValue);
		this.setState({foodWeeksRemaining: newValue});
	};

	foodWeekInfo = monthlies => {
		const foodMonthly = (monthlies || [])
			.filter(monthly => monthly.name === 'Food')
			.shift();
		return {
			weeksRemaining: this.state.foodWeeksRemaining || 0,
			weeklyAllotment: foodMonthly ? Math.max(0, foodMonthly.amountGoal - foodMonthly.amountSpent) / this.state.foodWeeksRemaining : 0,
		};
	};

	deleteMonthly = monthly => {
		if (this.state.deletingId === monthly.id) {
			this.setState({deletingId: undefined});
			webservice.iLoveAustin.monthly.delete(monthly.id)
				.then(() => this.setNewMonthliesList(this.props.iLoveAustin.monthlies.list.filter(filterMonthly => filterMonthly.id !== monthly.id)));
		} else {
			this.setState({deletingId: monthly.id});
		}
	};

	setNewMonthliesList = newList => dispatchUpdates([
		createPathActionPayload('iLoveAustin.monthlies.list', newList),
		createPathActionPayload('iLoveAustin.monthlies.totals', Period.totalMonthlies(newList)),
	]);


	addNewMonthly = () => this.setState({editingMonthly: {period: this.props.iLoveAustin.periods.period}});

	editMonthly = monthly => this.setState({editingMonthly: monthly});

	cancelMonthlyEdit = () => this.setState({editingMonthly: undefined});

	saveMonthly = monthlyToSave => {
		this.cancelMonthlyEdit();
		webservice.iLoveAustin.monthly.save(monthlyToSave)
			.then(monthlyResult => {
				let newList;
				if (this.props.iLoveAustin.monthlies.list.map(monthly => monthly.id).includes(monthlyResult.id)) {
					newList = this.props.iLoveAustin.monthlies.list.map(monthly => monthly.id === monthlyResult.id ? monthlyResult : monthly);
					dispatchField('iLoveAustin.monthlies.list', newList);
				} else {
					newList = this.props.iLoveAustin.monthlies.list.concat(monthlyResult);
				}
				this.setNewMonthliesList(newList);
			});
	};

	closeNotePopover = () => this.setState({popOverDetail: undefined});
	openNotePopover = (anchorEl, notes) => this.setState({popOverDetail: {anchorEl, notes}});

	render() {
		if (!this.props.iLoveAustin.monthlies.list) {
			return null;
		}

		const {classes} = this.props;
		const monthlies = this.props.iLoveAustin.monthlies.list;
		const foodWeekInfo = this.foodWeekInfo(this.props.iLoveAustin.monthlies.list);
		return (
			<Paper className={classes.root}>
				<Toolbar>
					<div className={classes.title}>
						<Typography variant="h6" id="tableTitle">
							Monthlies
						</Typography>
					</div>
					<div className={joinClassNames(classes.spacer, classes.toolbarMonthlyDatePicker)}>
						<MonthlyDatePicker/>
					</div>
					<div className={classes.actions} onClick={this.addNewMonthly}>
						<Tooltip title="Add New Monthly">
							<IconButton aria-label="add monthly">
								<AddCircleIcon />
							</IconButton>
						</Tooltip>
					</div>
				</Toolbar>
				<Table className={classes.table}>
					<TableHead>
						<TableRow>
							<TableCell>Name</TableCell>
							<TableCell align="right">Goal</TableCell>
							<TableCell align="right">Spent</TableCell>
							<TableCell align="right">Left</TableCell>
							<TableCell align="right">Weeks Remaining</TableCell>
							<TableCell align="right">Weekly Allotment</TableCell>
							<TableCell align="right"></TableCell>
						</TableRow>
					</TableHead>
					<TableBody>
						{monthlies.map((monthly, i) => (
							<TableRow
								className={classes.bodyTableRow}
								key={monthly.id}
								onClick={e => e.target.tagName !== 'INPUT' && this.editMonthly(monthly)}
							>
								<TableCell>
									<Grid container direction="row" alignItems="center">
										<Grid item>
											{monthly.name}
										</Grid>
										{
											monthly.notes ?
												<Grid item>
													<Typography
														aria-owns={this.state.popOverDetail ? 'mouse-over-popover' : undefined}
														aria-haspopup="true"
														onMouseEnter={e => this.openNotePopover(e.currentTarget, monthly.notes)}
														onMouseLeave={this.closeNotePopover}
													>
														<MessageIcon className={classes.tableCellTextIcon}/>
													</Typography>
													<Popover
														id="mouse-over-popover"
														className={classes.popover}
														classes={{
															paper: classes.popoverPaper,
														}}
														open={!!this.state.popOverDetail}
														anchorEl={this.state.popOverDetail && this.state.popOverDetail.anchorEl}
														anchorOrigin={{
															vertical: 'bottom',
															horizontal: 'left',
														}}
														transformOrigin={{
															vertical: 'top',
															horizontal: 'left',
														}}
														onClose={this.closeNotePopover}
														disableRestoreFocus
													>
														<div className={classes.renderLineBreaks}>
															<Typography>
																{this.state.popOverDetail && this.state.popOverDetail.notes}
															</Typography>
														</div>
													</Popover>
												</Grid>
												: undefined
										}
									</Grid>

								</TableCell>
								<TableCell align="right">{toDollarString(monthly.amountGoal)}</TableCell>
								<TableCell align="right">{toDollarString(monthly.amountSpent)}</TableCell>
								<TableCell align="right">{toDollarString(Math.max(0, monthly.amountGoal - monthly.amountSpent))}</TableCell>
								<TableCell align="right">
									{
										monthly.name === 'Food' ? <input
											className={classes.inputSizeSmall}
											type="text"
											value={foodWeekInfo.weeksRemaining}
											onChange={this.foodWeeksRemainingChange}
										/> : undefined
									}
								</TableCell>
								<TableCell align="right">{
									monthly.name === 'Food' ? toDollarString(foodWeekInfo.weeklyAllotment) : undefined
								}</TableCell>
								<TableCell align="right">
									<Button
										size="small"
										variant="contained"
										color="secondary"
										className={classes.button}
										onClick={handleEvent(() => this.deleteMonthly(monthly))}
									>
										{
											this.state.deletingId === monthly.id ?
											'Sure?' :
											<DeleteIcon fontSize="small" className={classes.rightIcon}/>
										}
									</Button>
								</TableCell>
							</TableRow>
						))}
					</TableBody>
					<TableFooter>
						<TableRow>
							<TableCell align="right">Totals:</TableCell>
							<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.monthlies.totals.amountGoal)}</b></TableCell>
							<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.monthlies.totals.amountSpent)}</b></TableCell>
							<TableCell align="right"><b>{toDollarString(this.props.iLoveAustin.monthlies.totals.amountLeft)}</b></TableCell>
							<TableCell/>
						</TableRow>
					</TableFooter>
				</Table>
				{this.state.editingMonthly ?
					<MonthlyEdit
						onCancel={this.cancelMonthlyEdit}
						onSave={this.saveMonthly}
						monthly={this.state.editingMonthly}
					/> : undefined}
			</Paper>
		);
	}
}

MonthlyList.propTypes = propTypes;
MonthlyList.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(MonthlyList)));
