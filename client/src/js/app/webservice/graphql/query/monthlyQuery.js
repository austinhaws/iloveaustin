import monthlyType from "../type/monthlyType";

export default period => `
  monthlies${period ? `(period: "${period}")` : ''} {
  	${monthlyType()}
  }
`;
