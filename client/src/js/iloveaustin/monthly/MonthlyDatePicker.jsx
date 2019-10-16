import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import webservice from "../../app/webservice/Webservice";
import Button from "@material-ui/core/Button";
import Styles from "../../app/Styles";
import ChevronLeftIcon from '@material-ui/icons/ChevronLeft';
import ChevronRightIcon from '@material-ui/icons/ChevronRight';
import {dispatchField} from "../../app/Dispatch";

const propTypes = {
	iLoveAustin: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({
	iLoveAustin: state.iLoveAustin,
});

class MonthlyDatePicker extends React.Component {

	goToPeriod = newPeriod => {
		webservice.iLoveAustin.period.get(true, newPeriod)
			.then(period => {
				dispatchField('iLoveAustin.periods', {period: period.period, nextPeriod: period.nextPeriod, previousPeriod: period.previousPeriod});
				dispatchField('iLoveAustin.monthlies.list', period.monthlies || []);
			});
	};

	render() {
		if (!this.props.iLoveAustin.periods) {
			return null;
		}
		const {classes} = this.props;
		return (
			<div className={classes.root}>
				<h3 className={classes.sectionTitle}>
					<Button onClick={() => this.goToPeriod(this.props.iLoveAustin.periods.previousPeriod)}><ChevronLeftIcon fontSize="small"/></Button>
					{this.props.iLoveAustin.periods.period}
					<Button onClick={() => this.goToPeriod(this.props.iLoveAustin.periods.nextPeriod)}><ChevronRightIcon fontSize="small"/></Button>
				</h3>
			</div>
		);
	}
}

MonthlyDatePicker.propTypes = propTypes;
MonthlyDatePicker.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(Styles)(MonthlyDatePicker)));
