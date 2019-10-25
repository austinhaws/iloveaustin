import moment from "moment";

export default {
	isValidMonthYear: dateText => (dateText || '').replace('_', '').length === 7 && moment(dateText, 'MM/YYYY').isValid(),
	isValidDate: dateText => (dateText || '').replace('_', '').length === 10 && moment(dateText,'MM/DD/YYYY').isValid(),
};
