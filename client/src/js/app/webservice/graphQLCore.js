import axios from "axios";

export default class GraphQLCore {

	/**
	 *
	 * @param baseUrl (optional) baseurl to add to front of all calls
	 * @param ajaxStatusCore AjaxStatusCore (optional) engine for recording when ajax start/stopped
	 * @param jsLogging (optional) jsLogging object if using jsLogging
	 * @param loadDefaultsCallback (optional) (axios.defaults) => useful for setting headers or other deafult information for axios calls: https://github.com/axios/axios => Config Defaults
	 * @param rawPromiseCallback (optional) (function) => get the axios promise (note that data is in result.data) as this gives the full axios response data; this promise has no other handlers called on it yet, so you will get the raw promise results; great for handling http exceptions; return the promise from the callback
	 * @param handledPromiseCallback (optional) (function) => disseminated promise data after generic catch and then handling
	 */
	constructor({
					graphQLUrl,
					ajaxStatusCore,
					jsLogging,
					loadDefaultsCallback,
					rawPromiseCallback,
					handledPromiseCallback,
				} = {}) {
		this.data = {
			graphQLUrl: graphQLUrl,
			ajaxStatusCore: ajaxStatusCore,
			jsLogging: jsLogging,
			loadDefaultsCallback: loadDefaultsCallback,
			rawPromiseCallback: rawPromiseCallback,
			handledPromiseCallback: handledPromiseCallback,
		};
		if (!graphQLUrl) {
			console.error('GraphQLCore requires a graphQL url');
		}
	}

	requestWithData = (verb, graphQLMessage, ajaxId) => {
		this.data.loadDefaultsCallback && this.data.loadDefaultsCallback(axios.defaults);
		this.ajaxStateChange(ajaxId, true);
		return this.catchPromise(ajaxId, axios[verb](this.data.graphQLUrl, graphQLMessage));
	};

	/**
	 * @param query the graphql query/mutation
	 * @param ajaxId ID for ajax status core
	 * @return {*}
	 */
	query = (query, ajaxId) => this.requestWithData('post', {query: `query { ${query} }`}, ajaxId);

	/**
	 * @param mutation mutation for graphql call
	 * @param ajaxId ID for ajax status core
	 * @return {*}
	 */
	mutation = (mutation, ajaxId) => this.requestWithData('post', {query: `mutation { ${mutation} }`}, ajaxId);

	/**
	 * before the endpoint is available, the webservice can "mock" a call
	 * the mocked call will return back whatever you pass to it
	 * the mocked call will be easily replaced by get/post or whatever verb is needed
	 *
	 * @param graphQLMessage
	 * @param ajaxId
	 * @param returnData
	 * @return {Promise<any>}
	 */
	mock = (graphQLMessage, ajaxId, returnData) => {
		console.error('Mocked Call', graphQLMessage, ajaxId, returnData);
		return Promise.resolve(returnData);
	};

	// internal methods, don't worry about this
	ajaxStateChange(ajaxId, ajaxStarted) {
		this.data.ajaxStatusCore && this.data.ajaxStatusCore.changeAjaxing(ajaxId, ajaxStarted);
	}

	catchPromise(ajaxId, promise) {
		// provide raw access to the promise
		let resultPromise = this.data.rawPromiseCallback ? this.data.rawPromiseCallback(promise) : promise;

		// do global handling and return just data from axios result
		resultPromise = resultPromise
		// turn off ajax spinner; catch first in case there was an error
			.catch(error => {
				this.ajaxStateChange((ajaxId, false));
				throw error;
			})
			// turn off ajax spinner; then after catch so if there wasn't an error (don't want to turn off ajax twice)
			.then(result => {
				this.ajaxStateChange(ajaxId, false);
				return result.data;
			})

			// allow webservice core owner a crack at all data coming back
			.then(result => this.data.allResultsCallback ? this.data.allResultsCallback(result) : result)

			// handle any errors up to this point
			.catch(error => {
				console.error(error);
				this.data.jsLogging && this.data.jsLogging.log(error);

				// propagate the error
				throw error;
			});

		// allow global handling after the promise is disseminated
		resultPromise = this.data.handledPromiseCallback ? this.data.handledPromiseCallback(resultPromise) : resultPromise;

		return resultPromise;
	}
}
