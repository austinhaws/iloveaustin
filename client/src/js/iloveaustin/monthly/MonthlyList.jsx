import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {IconButton, Toolbar, Tooltip, Typography, withStyles} from "@material-ui/core";
import Paper from "@material-ui/core/Paper";
import Table from "@material-ui/core/Table";
import TableHead from "@material-ui/core/TableHead";
import TableRow from "@material-ui/core/TableRow";
import TableCell from "@material-ui/core/TableCell";
import TableBody from "@material-ui/core/TableBody";
import {toDollarString} from "../../app/Money";
import TableFooter from "@material-ui/core/TableFooter";
import Button from "@material-ui/core/Button";
import DeleteIcon from '@material-ui/icons/Delete';
import styles from "../../app/Styles";
import {handleEvent, joinClassNames} from "dts-react-common";
import MonthlyDatePicker from "./MonthlyDatePicker";
import LocalStorage from "../../app/localstorage/LocalStorage";
import webservice from "../../app/webservice/Webservice";
import {dispatchField} from "../../app/Dispatch";
import AddCircleIcon from '@material-ui/icons/AddCircle';
import MonthlyEdit from "./MonthlyEdit";

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
				.then(() => dispatchField('iLoveAustin.monthlies.list', this.props.iLoveAustin.monthlies.list.filter(filterMonthly => filterMonthly.id !== monthly.id)));
		} else {
			this.setState({deletingId: monthly.id});
		}
	};

	editMonthly = monthly => {
		this.setState({editingMonthly: monthly});
	};

	cancelMonthlyEdit = () => this.setState({editingMonthly: undefined});

	saveMonthly = monthlyToSave => {
		this.cancelMonthlyEdit();
		webservice.iLoveAustin.monthly.save(monthlyToSave)
			.then(monthlyResult => {
				if (this.props.iLoveAustin.monthlies.list.map(monthly => monthly.id).includes(monthlyResult.id)) {
					dispatchField('iLoveAustin.monthlies.list', this.props.iLoveAustin.monthlies.list
						.map(monthly => monthly.id === monthlyResult.id ? monthlyResult : monthly));
				} else {
					dispatchField('iLoveAustin.monthlies.list', this.props.iLoveAustin.monthlies.list.concat(monthlyResult));
				}
			});
	};

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
					<div className={classes.actions}>
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
							<TableCell/>
						</TableRow>
					</TableHead>
					<TableBody>
						{monthlies.map((monthly, i) => (
							<TableRow
								className={classes.bodyTableRow}
								key={monthly.id}
								onClick={e => e.target.tagName !== 'INPUT' && this.editMonthly(monthly)}
							>
								<TableCell component="th" scope="row">{monthly.name}</TableCell>
								<TableCell align="right">{toDollarString(monthly.amountGoal)}</TableCell>
								<TableCell align="right">{toDollarString(monthly.amountSpent)}</TableCell>
								<TableCell align="right">{toDollarString(Math.max(0, monthly.amountGoal - monthly.amountSpent))}</TableCell>
								<TableCell align="right">{
									monthly.name === 'Food' ? <input
										className={classes.inputSizeSmall}
										type="text"
										value={foodWeekInfo.weeksRemaining}
										onChange={this.foodWeeksRemainingChange}
									/> : undefined
								}</TableCell>
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
