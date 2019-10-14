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
import {formatPeriod, Periods} from "../../app/Period";

const propTypes = {
	month: PropTypes.string,
	year: PropTypes.string,
};
const defaultProps = {
	month: undefined,
	year: undefined,
};
const mapStateToProps = state => ({
	app: state.app,
	iLoveAustin: state.iLoveAustin,
});

class MonthlyDatePicker extends React.Component {

	constructor(props) {
		super(props);

		this.state = {
			editSnapshot: undefined,
		};
	}

	componentDidMount() {
		webservice.iLoveAustin.period.get(this.props.month, this.props.year);
	};

	goToPeriod = periodName => {
		const period = this.props.iLoveAustin.periods[periodName];
		webservice.iLoveAustin.period.get(period.month, period.year);
	};

	render() {
		if (!this.props.iLoveAustin.periods) {
			return null;
		}
		const {classes} = this.props;
		return (
			<div className={classes.root}>
				<h3 className={classes.sectionTitle}>
					<Button onClick={() => this.goToPeriod(Periods.LAST)}><ChevronLeftIcon fontSize="small"/></Button>
					{formatPeriod(Periods.USE)}
					<Button onClick={() => this.goToPeriod(Periods.NEXT)}><ChevronRightIcon fontSize="small"/></Button>
				</h3>
			</div>
		);
	}
}

MonthlyDatePicker.propTypes = propTypes;
MonthlyDatePicker.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(Styles)(MonthlyDatePicker)));
