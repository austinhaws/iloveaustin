import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import green from '@material-ui/core/colors/green';

const propTypes = {};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
});

const styles = theme => ({
	root: {
		display: 'flex',
		flexWrap: 'wrap',
		flexDirection: 'column',
		width: '50%',
		margin: '50px auto 0',
		textAlign: 'center',
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

class Home extends React.Component {
	render() {
		const { classes } = this.props;

		return (
			<div className={classes.root}>
				{
					this.props.app.account ?
						<div>Click a menu item to get started</div> :
						<div>Welcome to the finances for the Haws.<br/> Click Sign In in the top right to get started.</div>
				}
			</div>
		);
	}
}

Home.propTypes = propTypes;
Home.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(Home)));
