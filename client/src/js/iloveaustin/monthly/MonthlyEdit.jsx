import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {Dialog, DialogActions, DialogContent, DialogTitle, IconButton, TextField, Typography, withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import Styles from "../../app/Styles";
import Button from "@material-ui/core/Button";
import CloseIcon from '@material-ui/icons/Close';

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

class MonthlyEdit extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			originalMonthly: this.props.monthly,
			editingMonthly: {...this.props.monthly},
			amountSpentAdd: undefined,
		}
	}

	onFieldChange = field => e => this.setState({ editingMonthly: { ...this.state.editingMonthly, [field]: e.target.value }});

	onAmountSpentAddChange = e => this.setState({amountSpentAdd: e.target.value});

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
							value={this.state.editingMonthly.name}
							onChange={this.onFieldChange('name')}
						/>
						<TextField
							margin="dense"
							id="goal"
							label="Goal"
							fullWidth
							value={this.state.editingMonthly.amountGoal}
							onChange={this.onFieldChange('amountGoal')}
						/>
						<TextField
							margin="dense"
							id="spent"
							label="Spent"
							fullWidth
							value={this.state.editingMonthly.amountSpent}
							onChange={this.onFieldChange('amountSpent')}
						/>
						<TextField
							margin="dense"
							id="add-spent"
							label="Add to Spent"
							fullWidth
							value={this.state.amountSpentAdd || "$0.00"}
							onChange={this.onAmountSpentAddChange}
						/>
						<TextField
							margin="dense"
							id="notes"
							label="Notes"
							fullWidth
							value={this.state.editingMonthly.notes}
							onChange={this.onFieldChange('notes')}
							multiline={true}
						/>
					</DialogContent>
					<DialogActions>
						<Button onClick={this.props.onCancel} color="primary">
							Cancel
						</Button>
						<Button onClick={() => this.props.onSave(this.state.editingMonthly)} color="primary">
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
