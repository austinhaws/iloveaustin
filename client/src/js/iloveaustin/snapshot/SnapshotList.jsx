import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import webservice from "../../app/Webservice";
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
import {handleEvent} from "dts-react-common";

const propTypes = {
	history: PropTypes.object.isRequired,
	editSnapshot: PropTypes.func.isRequired,
	deleteSnapshot: PropTypes.func.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class SnapshotList extends React.Component {

	componentDidMount() {
		webservice.iLoveAustin.snapshot.list();
	};

	render() {
		if (!this.props.iLoveAustin.snapshots) {
			return null;
		}

		const {classes} = this.props;
		return (
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
								onClick={() => this.props.editSnapshot(snapshot)}
							>
								<TableCell component="th" scope="row">{snapshot.name}</TableCell>
								<TableCell align="right">{toDollarString(snapshot.amt_goal)}</TableCell>
								<TableCell align="right">{toDollarString(snapshot.amt_current)}</TableCell>
								<TableCell align="right">
									<Button
										size="small"
										variant="contained"
										color="secondary"
										className={classes.button}
										onClick={handleEvent(() => this.props.deleteSnapshot(snapshot))}
									>
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
		);
	}
}

SnapshotList.propTypes = propTypes;
SnapshotList.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(SnapshotList)));
