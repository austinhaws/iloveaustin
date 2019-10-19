import periodType from "../type/periodType";
import snapshotQuery from "./snapshotQuery";

export default (period, includeMonthlies) => `
  period${period ? `(period: "${period}")` : ''} {
  	${periodType(includeMonthlies)}
  }
  ${includeMonthlies ? snapshotQuery() : ''}
`;
