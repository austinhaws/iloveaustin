import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {CircularProgress, withStyles} from "@material-ui/core";
import * as PropTypes from "prop-types";
import Button from "@material-ui/core/Button";
import Styles from "../../app/Styles";
import ChevronLeftIcon from '@material-ui/icons/ChevronLeft';
import ChevronRightIcon from '@material-ui/icons/ChevronRight';
import Period from "../../app/period/Period";
import MaskedInput from 'react-text-mask';
import {joinClassNames} from "dts-react-common";
import DateValidation from '../../app/date/DateValidation';

const propTypes = {
	app: PropTypes.object.isRequired,
	iLoveAustin: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class MonthlyDatePicker extends React.Component {

	changePeriod = e => e.target.value.replace('_', '').length === 7 &&
		DateValidation.isValidMonthYear(e.target.value) &&
		Period.moveToPeriod(e.target.value);

	render() {
		if (!this.props.iLoveAustin.periods) {
			Period.current();
			return null;
		}
		const {classes} = this.props;
		return (
			<div className={classes.root}>
				<h3 className={classes.sectionTitle}>
					<Button onClick={() => Period.moveToPeriod(this.props.iLoveAustin.periods.previousPeriod)}><ChevronLeftIcon fontSize="small"/></Button>
					<MaskedInput
						className={joinClassNames(classes.inputSizeMedium, classes.textAlignCenter, classes.dateTimePickerInput)}
						mask={[/\d/, /\d/, '/', /\d/, /\d/, /\d/, /\d/]}
						value={this.props.iLoveAustin.periods.period}
						onChange={this.changePeriod}
						disabled={this.props.app.ajaxSpinnerCount}
					/>
					{this.props.app.ajaxSpinnerCount ? <CircularProgress size={20}/> : undefined}
					<Button onClick={() => Period.moveToPeriod(this.props.iLoveAustin.periods.nextPeriod)}><ChevronRightIcon fontSize="small"/></Button>
				</h3>
			</div>
		);
	}
}

MonthlyDatePicker.propTypes = propTypes;
MonthlyDatePicker.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(Styles)(MonthlyDatePicker)));
