export default includeMonthlies => `
	period
	nextPeriod
	previousPeriod
	${includeMonthlies ? 'monthlies' : ''}
`;
