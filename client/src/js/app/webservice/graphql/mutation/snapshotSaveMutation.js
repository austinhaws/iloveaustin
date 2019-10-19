import includeIfNotUndefined from "../util/includeIfNotUndefined";
import snapshotType from "../type/snapshotType";

export default snapshot => `
	saveSnapshot (snapshot: {
		${includeIfNotUndefined('id', snapshot.id)}
		${includeIfNotUndefined('name', snapshot.name)}
		${includeIfNotUndefined('notes', snapshot.notes)}
		${includeIfNotUndefined('amountGoal', snapshot.amountGoal)}
		${includeIfNotUndefined('amountCurrent', snapshot.amountCurrent)}
		${includeIfNotUndefined('isTotalable', snapshot.isTotalable)}
	}) {
		${snapshotType()}
	}
`;
