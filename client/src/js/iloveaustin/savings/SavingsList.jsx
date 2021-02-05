import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {Grid, IconButton, Popover, TableFooter, Toolbar, Tooltip, Typography, withStyles} from "@material-ui/core";
import Paper from "@material-ui/core/Paper";
import Table from "@material-ui/core/Table";
import TableHead from "@material-ui/core/TableHead";
import TableRow from "@material-ui/core/TableRow";
import TableCell from "@material-ui/core/TableCell";
import TableBody from "@material-ui/core/TableBody";
import {toDollarString} from "../../app/money/Money";
import Button from "@material-ui/core/Button";
import DeleteIcon from '@material-ui/icons/Delete';
import MessageIcon from '@material-ui/icons/Message';
import styles from "../../app/Styles";
import {handleEvent} from "@dts-soldel/dts-react-common";
import webservice from "../../app/webservice/Webservice";
import {dispatchField} from "../../app/Dispatch";
import AddCircleIcon from '@material-ui/icons/AddCircle';
import SavingsEdit from "./SavingsEdit";

const propTypes = {};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class SavingsList extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			deletingId: undefined,
			editingSavings: undefined,
			popOverDetail: undefined,
		};
	}

	deleteSavings = savings => {
		if (this.state.deletingId === savings.id) {
			this.setState({deletingId: undefined});
			webservice.iLoveAustin.savings.delete(savings.id)
				.then(() => dispatchField('iLoveAustin.savings.list', this.props.iLoveAustin.savings.list.filter(filterSavings => filterSavings.id !== savings.id)));
		} else {
			this.setState({deletingId: savings.id});
		}
	};

	addNewSavings = () => this.setState({editingSavings: {}});

	editSavings = editingSavings => this.setState({editingSavings});

	cancelSavingsEdit = () => this.setState({editingSavings: undefined});

	saveSavings = savingsToSave => {
		this.cancelSavingsEdit();
		webservice.iLoveAustin.savings.save(savingsToSave)
			.then(savingsResult => {
				if (this.props.iLoveAustin.savings.list.map(savings => savings.id).includes(savingsResult.id)) {
					dispatchField('iLoveAustin.savings.list', this.props.iLoveAustin.savings.list
						.map(savings => savings.id === savingsResult.id ? savingsResult : savings));
				} else {
					const newList = this.props.iLoveAustin.savings.list.concat(savingsResult);
					newList.sort(((a, b) => a.name.localeCompare(b.name)));
					dispatchField('iLoveAustin.savings.list', newList);
				}
			});
	};

	closeNotePopover = () => this.setState({popOverDetail: undefined});
	openNotePopover = (anchorEl, notes) => this.setState({popOverDetail: {anchorEl, notes}});

	render() {
		if (!this.props.iLoveAustin.savings.list) {
			return null;
		}

		const {classes} = this.props;
		const savings = this.props.iLoveAustin.savings.list;
		return (
			<Paper className={classes.root}>
				<Toolbar>
					<div className={classes.title}>
						<Typography variant="h6" id="tableTitle">
							Savings
						</Typography>
					</div>
					<div className={classes.spacer}/>
					<div className={classes.actions} onClick={this.addNewSavings}>
						<Tooltip title="Add New Savings">
							<IconButton aria-label="add savings">
								<AddCircleIcon />
							</IconButton>
						</Tooltip>
					</div>
				</Toolbar>
				<Table className={classes.table}>
					<TableHead>
						<TableRow>
							<TableCell>Name</TableCell>
							<TableCell align="right">Due Date</TableCell>
							<TableCell align="right">Goal</TableCell>
							<TableCell align="right">Current</TableCell>
							<TableCell align="right"></TableCell>
						</TableRow>
					</TableHead>
					<TableBody>
						{savings.map((savings, i) => (
							<TableRow
								className={classes.bodyTableRow}
								key={savings.id}
								onClick={e => e.target.tagName !== 'INPUT' && this.editSavings(savings)}
							>
								<TableCell>
									<Grid container direction="row" alignItems="center">
										<Grid item>
											{savings.name}
										</Grid>
										{
											savings.notes ?
												<Grid item>
													<Typography
														aria-owns={this.state.popOverDetail ? 'mouse-over-popover' : undefined}
														aria-haspopup="true"
														onMouseEnter={e => this.openNotePopover(e.currentTarget, savings.notes)}
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
								<TableCell>{savings.dueDate}</TableCell>
								<TableCell align="right" >{toDollarString(savings.amountGoal)}</TableCell>
								<TableCell align="right">{toDollarString(savings.amountCurrent)}</TableCell>
								<TableCell align="right">
									<Button
										size="small"
										variant="contained"
										color="secondary"
										className={classes.button}
										onClick={handleEvent(() => this.deleteSavings(savings))}
									>
										{
											this.state.deletingId === savings.id ?
											'Sure?' :
											<DeleteIcon fontSize="small" className={classes.rightIcon}/>
										}
									</Button>
								</TableCell>
							</TableRow>
						))}
					</TableBody>
					<TableFooter>
						<TableRow className={classes.bodyTableRow}>
							<TableCell/>
							<TableCell align="right">Total:</TableCell>
							<TableCell align="right">{toDollarString(savings.reduce((total, saving) => total + +(saving.amountGoal || 0), 0))}</TableCell>
							<TableCell align="right">{toDollarString(savings.reduce((total, saving) => total + +(saving.amountCurrent || 0), 0))}</TableCell>
							<TableCell/>
						</TableRow>
					</TableFooter>
				</Table>
				{this.state.editingSavings ?
					<SavingsEdit
						onCancel={this.cancelSavingsEdit}
						onSave={this.saveSavings}
						savings={this.state.editingSavings}
					/> : undefined}
			</Paper>
		);
	}
}

SavingsList.propTypes = propTypes;
SavingsList.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(SavingsList)));
