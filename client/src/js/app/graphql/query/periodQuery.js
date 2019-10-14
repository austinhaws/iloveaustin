import periodType from "../type/periodType";

export default (month, year, includeMonthlies) => `
{
  period${(month && year) ? `(${month}/${year})` : ''} {
  	${periodType(includeMonthlies)}
  }
}
`;
