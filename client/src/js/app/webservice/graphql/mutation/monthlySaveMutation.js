import includeIfNotUndefined from "../util/includeIfNotUndefined";
import monthlyType from "../type/monthlyType";

export default monthly => `
{ 
	saveMonthly (monthly: {
		${includeIfNotUndefined('id', monthly.id)}
		${includeIfNotUndefined('period', monthly.period)}
		${includeIfNotUndefined('name', monthly.name)}
		${includeIfNotUndefined('notes', monthly.notes)}
		${includeIfNotUndefined('amountGoal', monthly.amountGoal)}
		${includeIfNotUndefined('amountSpent', monthly.amountSpent)}
	}) {
		${monthlyType()}
	}
}
`;
