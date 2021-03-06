import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {Dialog, DialogActions, DialogContent, DialogTitle, IconButton, TextField, Typography, withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import Styles from "../../app/Styles";
import Button from "@material-ui/core/Button";
import CloseIcon from '@material-ui/icons/Close';
import {addPlainMoney, toDirtyMoney, toPlainMoney} from "../../app/money/Money";
import MoneyMaskInput from "../masks/MoneyMaskInput";
import DateMaskInput from "../masks/DateMaskInput";
import DateValidation from "../../app/date/DateValidation";
import {MessagePopupCore} from "dts-react-common";

const propTypes = {
	classes: PropTypes.object.isRequired,
	onCancel: PropTypes.func.isRequired,
	onSave: PropTypes.func.isRequired,
	savings: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({});

class SavingsEdit extends React.Component {

	constructor(props) {
		super(props);
		this.savingsMoneyFields = [
			'amountGoal',
			'amountCurrent'
		];

		const editingSavings = {...this.props.savings};

		this.savingsMoneyFields.forEach(field => editingSavings[field] = toDirtyMoney(editingSavings[field]));

		this.state = {
			editingSavings,
			amountCurrentAdd: '$0.00',
			amountCurrentTotal: editingSavings['amountCurrent'],
		};
	}

	onFieldChange = field => e => {
		if (field === 'amountCurrent') {
			this.calculateAmountCurrentWithAdd(e.target.value, this.state.amountCurrentAdd);
		}
		this.setState({ editingSavings: { ...this.state.editingSavings, [field]: e.target.value }});
	};

	onAmountCurrentAddChange = e => {
		this.calculateAmountCurrentWithAdd(this.state.editingSavings.amountCurrent, e.target.value);
		this.setState({amountCurrentAdd: e.target.value})
	};

	calculateAmountCurrentWithAdd = (amountCurrent, amountCurrentAdd) => this.setState({
		amountCurrentTotal: toDirtyMoney(addPlainMoney(
			toPlainMoney(amountCurrent),
			toPlainMoney(amountCurrentAdd)
		))
	});

	save = () => {
		const saveSavings = {...this.state.editingSavings};
		if (!this.state.editingSavings.dueDate || DateValidation.isValidDate(this.state.editingSavings.dueDate)) {
			saveSavings.amountCurrent = this.state.amountCurrentTotal;
			this.savingsMoneyFields.forEach(field => saveSavings[field] = toPlainMoney(saveSavings[field]));
			this.props.onSave(saveSavings);
		} else {
			MessagePopupCore.addMessage({title: 'Cannot Save', message: `The Due Date entered is not a valid date: ${saveSavings.dueDate}`});
		}
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
						<Typography>{this.state.editingSavings.id ? 'Edit' : 'Add'} Savings</Typography>
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
							value={this.state.editingSavings.name || ''}
							onChange={this.onFieldChange('name')}
						/>
						<TextField
							margin="dense"
							id="due-date"
							label="Due Date"
							fullWidth
							error = {this.state.editingSavings.dueDate && !DateValidation.isValidDate(this.state.editingSavings.dueDate)}
							InputProps={{
								inputComponent: DateMaskInput,
								value: this.state.editingSavings.dueDate || '',
								onChange: this.onFieldChange('dueDate'),
							}}
						/>
						<TextField
							margin="dense"
							id="goal"
							label="Goal"
							fullWidth
							InputProps={{
								inputComponent: MoneyMaskInput,
								value: this.state.editingSavings.amountGoal || "$0.00",
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
								value: this.state.editingSavings.amountCurrent || "$0.00",
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
								value: this.state.editingSavings.amountCurrentAdd || "$0.00",
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
							value={this.state.editingSavings.notes || ''}
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

SavingsEdit.propTypes = propTypes;
SavingsEdit.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(Styles)(SavingsEdit)));
