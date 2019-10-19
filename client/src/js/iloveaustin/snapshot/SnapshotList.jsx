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
import Button from "@material-ui/core/Button";
import DeleteIcon from '@material-ui/icons/Delete';
import MessageIcon from '@material-ui/icons/Message';
import styles from "../../app/Styles";
import {handleEvent} from "dts-react-common";
import webservice from "../../app/webservice/Webservice";
import {dispatchField} from "../../app/Dispatch";
import AddCircleIcon from '@material-ui/icons/AddCircle';
import SnapshotEdit from "./SnapshotEdit";

const propTypes = {};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class SnapshotList extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			deletingId: undefined,
			editingSnapshot: undefined,
			popOverDetail: undefined,
		};
	}

	deleteSnapshot = snapshot => {
		if (this.state.deletingId === snapshot.id) {
			this.setState({deletingId: undefined});
			webservice.iLoveAustin.snapshot.delete(snapshot.id)
				.then(() => dispatchField('iLoveAustin.snapshots.list', this.props.iLoveAustin.snapshots.list.filter(filterSnapshot => filterSnapshot.id !== snapshot.id)));
		} else {
			this.setState({deletingId: snapshot.id});
		}
	};

	addNewSnapshot = () => this.setState({editingSnapshot: {}});

	editSnapshot = editingSnapshot => this.setState({editingSnapshot});

	cancelSnapshotEdit = () => this.setState({editingSnapshot: undefined});

	saveSnapshot = snapshotToSave => {
		this.cancelSnapshotEdit();
		webservice.iLoveAustin.snapshot.save(snapshotToSave)
			.then(snapshotResult => {
				if (this.props.iLoveAustin.snapshots.list.map(snapshot => snapshot.id).includes(snapshotResult.id)) {
					dispatchField('iLoveAustin.snapshots.list', this.props.iLoveAustin.snapshots.list
						.map(snapshot => snapshot.id === snapshotResult.id ? snapshotResult : snapshot));
				} else {
					dispatchField('iLoveAustin.snapshots.list', this.props.iLoveAustin.snapshots.list.concat(snapshotResult));
				}
			});
	};

	closeNotePopover = () => this.setState({popOverDetail: undefined});
	openNotePopover = (anchorEl, notes) => this.setState({popOverDetail: {anchorEl, notes}});

	render() {
		if (!this.props.iLoveAustin.snapshots.list) {
			return null;
		}

		const {classes} = this.props;
		const snapshots = this.props.iLoveAustin.snapshots.list;
		return (
			<Paper className={classes.root}>
				<Toolbar>
					<div className={classes.title}>
						<Typography variant="h6" id="tableTitle">
							Snapshots
						</Typography>
					</div>
					<div className={classes.spacer}/>
					<div className={classes.actions} onClick={this.addNewSnapshot}>
						<Tooltip title="Add New Snapshot">
							<IconButton aria-label="add snapshot">
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
							<TableCell align="right">Current</TableCell>
							<TableCell align="right"></TableCell>
						</TableRow>
					</TableHead>
					<TableBody>
						{snapshots.map((snapshot, i) => (
							<TableRow
								className={classes.bodyTableRow}
								key={snapshot.id}
								onClick={e => e.target.tagName !== 'INPUT' && this.editSnapshot(snapshot)}
							>
								<TableCell className={!snapshot.isTotalable ? classes.redColor : undefined}>
									<Grid container direction="row" alignItems="center">
										<Grid item>
											{snapshot.name}
										</Grid>
										{
											snapshot.notes ?
												<Grid item>
													<Typography
														aria-owns={this.state.popOverDetail ? 'mouse-over-popover' : undefined}
														aria-haspopup="true"
														onMouseEnter={e => this.openNotePopover(e.currentTarget, snapshot.notes)}
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
								<TableCell align="right" className={!snapshot.isTotalable ? classes.redColor : undefined}>{toDollarString(snapshot.amountGoal)}</TableCell>
								<TableCell align="right" className={!snapshot.isTotalable ? classes.redColor : undefined}>{toDollarString(snapshot.amountCurrent)}</TableCell>
								<TableCell align="right">
									<Button
										size="small"
										variant="contained"
										color="secondary"
										className={classes.button}
										onClick={handleEvent(() => this.deleteSnapshot(snapshot))}
									>
										{
											this.state.deletingId === snapshot.id ?
											'Sure?' :
											<DeleteIcon fontSize="small" className={classes.rightIcon}/>
										}
									</Button>
								</TableCell>
							</TableRow>
						))}
					</TableBody>
				</Table>
				{this.state.editingSnapshot ?
					<SnapshotEdit
						onCancel={this.cancelSnapshotEdit}
						onSave={this.saveSnapshot}
						snapshot={this.state.editingSnapshot}
					/> : undefined}
			</Paper>
		);
	}
}

SnapshotList.propTypes = propTypes;
SnapshotList.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(SnapshotList)));
