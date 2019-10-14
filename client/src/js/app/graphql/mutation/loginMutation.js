import accountType from "../type/accountType";

export default googleResponse => `
{
  login(Authorization:"${googleResponse.tokenId}") {
  	${accountType()}
  }
}
`;
