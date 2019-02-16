import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {TextField, withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import webservice, {ajaxStatus} from "../app/Webservice";
import FormControl from "@material-ui/core/FormControl";
import Button from "@material-ui/core/Button";
import CircularProgress from "@material-ui/core/CircularProgress";
import green from '@material-ui/core/colors/green';
import {dispatchField} from "../app/Dispatch";
import Pages from "../app/Pages";

const propTypes = {
	history: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
});

const styles = theme => ({
	root: {
		display: 'flex',
		flexWrap: 'wrap',
		flexDirection: 'column',
		width: '250px',
		margin: '0 auto',
	},
	formControl: {
		margin: theme.spacing.unit,
		minWidth: 120,
	},
	selectEmpty: {
		marginTop: theme.spacing.unit * 2,
	},
	buttonProgress: {
		color: green[500],
		position: 'absolute',
		top: '50%',
		left: '50%',
		marginTop: -12,
		marginLeft: -12,
	},
	slider: {
		padding: '22px 0px',
	},
});

class Login extends React.Component {

	constructor(props) {
		super(props);
		this.state = {
			username: '',
		};
	}

	login = () => {
		webservice.iLoveAustin.login(this.state)
			.then(token => token ? token : Promise.reject('Invalid login'))
			.then(token => token && dispatchField('app.postToken', token))
			.then(() => Pages.iLoveAustin.budget.forward(this.props.history))
			.catch(alert);
	};

	render() {
		const { classes } = this.props;
		const ajaxing = ajaxStatus.isAjaxing();

		return (
			<div className={classes.root}>
				{/* Name */}
				<FormControl className={classes.formControl}>
					<TextField
						label="Username"
						autoFocus={true}
						onChange={event => this.setState({ username: event.target.value })}
						placeholder="Random"
						value={this.state.username}
						disabled={ajaxing}
						inputProps={{ id: 'name', shrink: 'shrink' }}
						onKeyPress={e => e.key === 'Enter' && this.login()}
					/>
				</FormControl>

				{/* Login Button */}
				<FormControl className={classes.formControl}>
					<Button
						variant="contained"
						color="primary"
						onClick={this.login}
						disabled={ajaxing}
					>
						Login
					</Button>
					{ajaxing && <CircularProgress size={24} className={classes.buttonProgress} />}
				</FormControl>
			</div>
		);
	}
}

Login.propTypes = propTypes;
Login.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(Login)));
