import periodType from "../type/periodType";
import snapshotQuery from "./snapshotQuery";
import savingsQuery from "./savingsQuery";

export default (period, includeMonthlies) => `
  period${period ? `(period: "${period}", ${includeMonthlies ? `copyForward: true` : ''})` : ''} {
  	${periodType(includeMonthlies)}
  }
  ${includeMonthlies ? snapshotQuery() : ''}
  ${includeMonthlies ? savingsQuery() : ''}
`;
