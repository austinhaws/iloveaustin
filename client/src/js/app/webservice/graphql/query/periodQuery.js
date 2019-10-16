import periodType from "../type/periodType";

export default (period, includeMonthlies) => `
{
  period${period ? `(period: "${period}")` : ''} {
  	${periodType(includeMonthlies)}
  }
}
`;
