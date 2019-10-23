import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {Dialog, DialogActions, DialogContent, DialogTitle, IconButton, MenuItem, Select, TextField, Typography, withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import Styles from "../../app/Styles";
import Button from "@material-ui/core/Button";
import CloseIcon from '@material-ui/icons/Close';
import {addPlainMoney, toDirtyMoney, toPlainMoney} from "../../app/money/Money";
import MoneyMaskInput from "../masks/MoneyMaskInput";

const propTypes = {
	snapshot: PropTypes.object.isRequired,
	onCancel: PropTypes.func.isRequired,
	onSave: PropTypes.func.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({
//todo: does it really need the whole state?!
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class SnapshotEdit extends React.Component {

	constructor(props) {
		super(props);
		this.snapshotMoneyFields = [
			'amountGoal',
			'amountCurrent'
		];

		const editingSnapshot = {...this.props.snapshot};

		this.snapshotMoneyFields.forEach(field => editingSnapshot[field] = toDirtyMoney(editingSnapshot[field]));

		this.state = {
			editingSnapshot,
			amountCurrentAdd: '$0.00',
			amountCurrentTotal: editingSnapshot['amountCurrent'],
		}
	}

	onFieldChange = field => e => {
		if (field === 'amountCurrent') {
			this.calculateAmountCurrentWithAdd(e.target.value, this.state.amountCurrentAdd);
		}
		this.setState({ editingSnapshot: { ...this.state.editingSnapshot, [field]: e.target.value }});
	};

	onAmountCurrentAddChange = e => {
		this.calculateAmountCurrentWithAdd(this.state.editingSnapshot.amountCurrent, e.target.value);
		this.setState({amountCurrentAdd: e.target.value})
	};

	calculateAmountCurrentWithAdd = (amountCurrent, amountCurrentAdd) => this.setState({
		amountCurrentTotal: toDirtyMoney(addPlainMoney(
			toPlainMoney(amountCurrent),
			toPlainMoney(amountCurrentAdd)
		))
	});

	save = () => {
		const saveSnapshot = {...this.state.editingSnapshot};
		saveSnapshot.amountCurrent = this.state.amountCurrentTotal;
		this.snapshotMoneyFields.forEach(field => saveSnapshot[field] = toPlainMoney(saveSnapshot[field]));
		this.props.onSave(saveSnapshot);
	};

	render() {
		const {classes} = this.props;
		return (
			<div className={classes.root}>
				<Dialog
					open={true}
					onClose={this.props.onCancel}
					aria-labelledby="form-dialog-title"
				>
					<DialogTitle id="form-dialog-title">
						<Typography>{this.state.editingSnapshot.id ? 'Edit' : 'Add'} Snapshot</Typography>
						<IconButton aria-label="close" className={classes.dialogCloseButton} onClick={this.props.onCancel}>
							<CloseIcon />
						</IconButton>
					</DialogTitle>
					<DialogContent>
						<TextField
							autoFocus
							margin="dense"
							id="name"
							label="Name"
							fullWidth
							value={this.state.editingSnapshot.name || ''}
							onChange={this.onFieldChange('name')}
						/>
						<TextField
							autoFocus
							margin="dense"
							id="isTotalable"
							label="Add to the Well's Fargo total"
							fullWidth
							InputProps={{
								inputComponent: () => <Select
									className={classes.textFieldSelect}
									value={this.state.editingSnapshot.isTotalable || 0}
									onChange={this.onFieldChange('isTotalable')}
								>
									<MenuItem value={1}>Yes</MenuItem>
									<MenuItem value={0}>No</MenuItem>
								</Select>,
							}}
						/>
						<TextField
							margin="dense"
							id="goal"
							label="Goal"
							fullWidth
							InputProps={{
								inputComponent: MoneyMaskInput,
								value: this.state.editingSnapshot.amountGoal || "$0.00",
								onChange: this.onFieldChange('amountGoal'),
							}}
						/>

						<TextField
							margin="dense"
							id="current"
							label="Current"
							fullWidth
							InputProps={{
								inputComponent: MoneyMaskInput,
								value: this.state.editingSnapshot.amountCurrent || "$0.00",
								onChange: this.onFieldChange('amountCurrent'),
							}}
						/>
						<TextField
							margin="dense"
							id="add-current"
							label="Add to Current"
							fullWidth
							InputProps={{
								inputComponent: MoneyMaskInput,
								value: this.state.editingSnapshot.amountCurrentAdd || "$0.00",
								onChange: this.onAmountCurrentAddChange,
							}}
						/>
						<TextField
							margin="dense"
							id="total-current"
							label="Total Current"
							fullWidth
							value={this.state.amountCurrentTotal || "$0.00"}
							disabled={true}
						/>
						<TextField
							margin="dense"
							id="notes"
							label="Notes"
							fullWidth
							value={this.state.editingSnapshot.notes || ''}
							onChange={this.onFieldChange('notes')}
							multiline={true}
						/>
					</DialogContent>
					<DialogActions>
						<Button onClick={this.props.onCancel} color="primary">
							Cancel
						</Button>
						<Button onClick={this.save} color="primary">
							Save
						</Button>
					</DialogActions>
				</Dialog>
			</div>
		);
	}
}

SnapshotEdit.propTypes = propTypes;
SnapshotEdit.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(Styles)(SnapshotEdit)));
