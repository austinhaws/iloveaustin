import store from "./ReduxStore";

export const Periods = {
	CURRENT: 'currentPeriod',
	USE: 'period',
	NEXT: 'nextPeriod',
	LAST: 'lastPeriod',
};

export const formatPeriod = periodName => {
	const period = store.getState().iLoveAustin.periods[periodName];
	return `${period.month}/${period.year}`.padStart(7, '0');
};