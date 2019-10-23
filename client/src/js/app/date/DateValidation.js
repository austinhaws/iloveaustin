import moment from "moment";

export default {
	isValidMonthYear: dateText => (dateText || '').replace('_', '').length === 6 && moment(dateText, 'MM/YYYY').isValid(),
	isValidDate: dateText => (dateText || '').replace('_', '').length === 10 && moment(dateText,'MM/DD/YYYY').isValid(),
};
