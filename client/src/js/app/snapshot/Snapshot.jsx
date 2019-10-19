import React from "react";

const Snapshot = {
	totalSnapshots: snapshots => (snapshots || []).reduce((totals, snapshot) => {
		const amountGoal = parseInt(snapshot.amountGoal, 10) || 0;
		const amountCurrent = parseInt(snapshot.amountCurrent, 10) || 0;
		totals.amountGoal += amountGoal;
		totals.amountCurrent += amountCurrent;
		return totals;
	}, {amountGoal: 0, amountCurrent: 0}),
};

export default Snapshot;
