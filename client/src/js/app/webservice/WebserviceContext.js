export const CONTEXT_URL = {
	LOCAL: 'http://localhost/iloveaustin3/server/graphql.php',
	// DEV: 'http://localhost:8080/frontdoor/graphql',
	// AT: 'https://frontdoor-ws.at.utah.gov/frontdoor/graphql',
	// PROD: 'https://frontdoor-ws.utah.gov/frontdoor/graphql'
};

export default (document.location.hostname.includes('localhost')) ? CONTEXT_URL.LOCAL
	: (document.location.hostname.includes('.dev.')) ? CONTEXT_URL.DEV
		: (document.location.hostname.includes('.at.')) ? CONTEXT_URL.AT
			: CONTEXT_URL.PROD;
