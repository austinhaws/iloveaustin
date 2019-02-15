import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import green from '@material-ui/core/colors/green';

const propTypes = {
	citygen: PropTypes.object.isRequired,
	history: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({ citygen: state.citygen });

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

class CityGenGenerated extends React.Component {

	render() {
		console.log('generated!', this.props.citygen.generatedCity);
		return <div>show generated city</div>;
	}
}

CityGenGenerated.propTypes = propTypes;
CityGenGenerated.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(CityGenGenerated)));
