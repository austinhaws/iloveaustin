import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import webservice from "../../app/Webservice";
import {fromDollarString, toDollarString} from "../../app/Money";
import Button from "@material-ui/core/Button";
import SnapshotEdit from "./SnapshotEdit";
import styles from "../../app/Styles";
import SnapshotList from "./SnapshotList";

const propTypes = {
	history: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class Snapshot extends React.Component {

	constructor(props) {
		super(props);

		this.state = {
			editSnapshot: undefined,
		};
	}

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

	saveEditSnapshot = snapshot => {
		// convert $ strings to amount ints
		const saveSnapshot = { ...snapshot };
		saveSnapshot.amt_goal = fromDollarString(saveSnapshot.amt_goal);
		saveSnapshot.amt_current = fromDollarString(saveSnapshot.amt_current);
		saveSnapshot.amt_current += fromDollarString(saveSnapshot.add_current);

		webservice.iLoveAustin.snapshot.save(saveSnapshot)
			.then(() => this.setState({ editSnapshot: undefined }))
			.then(() => webservice.iLoveAustin.snapshot.list());
	};

	render() {
		const {classes} = this.props;
		return (
			<div className={classes.root}>
				<h3 className={classes.sectionTitle}>Snapshots</h3>
				<Button variant="outlined" className={classes.addButton} onClick={this.newSnapshot}>Add New Snapshot</Button>

				<SnapshotList
					editSnapshot={this.editSnapshot}
					deleteSnapshot={this.deleteSnapshot}
				/>

				{this.state.editSnapshot && (
					<SnapshotEdit
						snapshot={this.state.editSnapshot}
						saveSnapshot={this.saveEditSnapshot}
						cancelSnapshotEdit={() => this.setState({ editSnapshot: undefined })}
					/>
				)}
			</div>
		);
	}
}

Snapshot.propTypes = propTypes;
Snapshot.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(Snapshot)));
