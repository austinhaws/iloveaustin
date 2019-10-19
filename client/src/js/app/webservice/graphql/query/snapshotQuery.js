import snapshotType from "../type/snapshotType";

export default () => `
	snapshots  {
		${snapshotType()}
	}
`;
