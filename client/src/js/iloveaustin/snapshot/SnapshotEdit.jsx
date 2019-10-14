import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import Button from "@material-ui/core/Button";
import Dialog from "@material-ui/core/Dialog";
import DialogTitle from "@material-ui/core/DialogTitle";
import DialogContent from "@material-ui/core/DialogContent";
import TextField from "@material-ui/core/TextField";
import DialogActions from "@material-ui/core/DialogActions";
import Checkbox from "@material-ui/core/Checkbox";
import FormControlLabel from "@material-ui/core/FormControlLabel";
import styles from "../../app/Styles";

const propTypes = {
	cancelSnapshotEdit: PropTypes.func.isRequired,
	saveSnapshot: PropTypes.func.isRequired,
	snapshot: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class SnapshotEdit extends React.Component {

	constructor(props) {
		super(props);
console.log(props);
		this.state = {
			editSnapshot: {...props.snapshot},
		};
	}

	render() {
		return (
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
					<Button onClick={this.props.cancelSnapshotEdit} color="primary">
						Cancel
					</Button>
					<Button onClick={() => this.props.saveSnapshot(this.state.editSnapshot)} color="primary">
						Save
					</Button>
				</DialogActions>
			</Dialog>
		);
	}
}

SnapshotEdit.propTypes = propTypes;
SnapshotEdit.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(SnapshotEdit)));
