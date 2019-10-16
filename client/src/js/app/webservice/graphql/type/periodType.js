import monthlyType from "./monthlyType";

export default includeMonthlies => `
	period
	nextPeriod
	previousPeriod
	${includeMonthlies ? `monthlies {${monthlyType()}}` : ''}
`;
