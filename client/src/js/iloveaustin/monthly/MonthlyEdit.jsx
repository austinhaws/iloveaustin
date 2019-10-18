import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {Dialog, DialogActions, DialogContent, DialogTitle, IconButton, TextField, Typography, withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import Styles from "../../app/Styles";
import Button from "@material-ui/core/Button";
import CloseIcon from '@material-ui/icons/Close';
import MaskedInput from "react-text-mask";
import Masks from "../../app/masks/Masks";
import {addPlainMoney, toDirtyMoney, toPlainMoney} from "../../app/Money";

const propTypes = {
	monthly: PropTypes.object.isRequired,
	onCancel: PropTypes.func.isRequired,
	onSave: PropTypes.func.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({
//todo: does it really need the whole state?!
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

const NumberMaskInput = props => {
	// getting errors about inputRef not being valid
	const {inputRef, ...rest} = props;
	return <MaskedInput mask={Masks.moneyMask} {...rest}/>;
};

class MonthlyEdit extends React.Component {

	constructor(props) {
		super(props);
		this.monthlyMoneyFields = [
			'amountGoal',
			'amountSpent'
		];

		const editingMonthly = {...this.props.monthly};

		this.monthlyMoneyFields.forEach(field => editingMonthly[field] = toDirtyMoney(editingMonthly[field]));

		this.state = {
			editingMonthly,
			amountSpentAdd: '$0.00',
			amountSpentTotal: editingMonthly['amountSpent'],
		}
	}

	onFieldChange = field => e => {
		if (field === 'amountSpent') {
			this.calculateAmountSpentWithAdd(e.target.value, this.state.amountSpentAdd);
		}
		this.setState({ editingMonthly: { ...this.state.editingMonthly, [field]: e.target.value }});
	};

	onAmountSpentAddChange = e => {
		this.calculateAmountSpentWithAdd(this.state.editingMonthly.amountSpent, e.target.value);
		this.setState({amountSpentAdd: e.target.value})
	};

	calculateAmountSpentWithAdd = (amountSpent, amountSpentAdd) => this.setState({
		amountSpentTotal: toDirtyMoney(addPlainMoney(
			toPlainMoney(amountSpent),
			toPlainMoney(amountSpentAdd)
		))
	});

	save = () => {
		const saveMonthly = {...this.state.editingMonthly};
		saveMonthly.amountSpent = this.state.amountSpentTotal;
		this.monthlyMoneyFields.forEach(field => saveMonthly[field] = toPlainMoney(saveMonthly[field]));
		this.props.onSave(saveMonthly);
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
						<Typography>{this.state.editingMonthly.id ? 'Edit' : 'Add'} Monthly</Typography>
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
							value={this.state.editingMonthly.name || ''}
							onChange={this.onFieldChange('name')}
						/>
						<TextField
							margin="dense"
							id="goal"
							label="Goal"
							fullWidth
							InputProps={{
								inputComponent: NumberMaskInput,
								value: this.state.editingMonthly.amountGoal || "$0.00",
								onChange: this.onFieldChange('amountGoal'),
							}}
						/>

						<TextField
							margin="dense"
							id="spent"
							label="Spent"
							fullWidth
							InputProps={{
								inputComponent: NumberMaskInput,
								value: this.state.editingMonthly.amountSpent || "$0.00",
								onChange: this.onFieldChange('amountSpent'),
							}}
						/>
						<TextField
							margin="dense"
							id="add-spent"
							label="Add to Spent"
							fullWidth
							InputProps={{
								inputComponent: NumberMaskInput,
								value: this.state.editingMonthly.amountSpentAdd || "$0.00",
								onChange: this.onAmountSpentAddChange,
							}}
						/>
						<TextField
							margin="dense"
							id="total-spent"
							label="Total Spent"
							fullWidth
							value={this.state.amountSpentTotal || "$0.00"}
							disabled={true}
						/>
						<TextField
							margin="dense"
							id="notes"
							label="Notes"
							fullWidth
							value={this.state.editingMonthly.notes || ''}
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

MonthlyEdit.propTypes = propTypes;
MonthlyEdit.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(Styles)(MonthlyEdit)));
