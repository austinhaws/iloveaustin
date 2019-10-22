import includeIfNotUndefined from "../util/includeIfNotUndefined";
import savingsType from "../type/savingsType";

export default savings => `
	saveSavings (savings: {
		${includeIfNotUndefined('id', savings.id)}
		${includeIfNotUndefined('name', savings.name)}
		${includeIfNotUndefined('notes', savings.notes)}
		${includeIfNotUndefined('amountGoal', savings.amountGoal)}
		${includeIfNotUndefined('amountCurrent', savings.amountCurrent)}
		${includeIfNotUndefined('dueDate', savings.dueDate)}
	}) {
		${savingsType()}
	}
`;
