module.exports = function(api) {
	api.cache(false);
	return {
		"presets": [
			[
				"@babel/preset-env",
				{
					"useBuiltIns": "entry"
				}
			],
			"@babel/preset-react"
		],
		"plugins": [
			"@babel/plugin-proposal-class-properties",
			"@babel/plugin-proposal-object-rest-spread"
		]
	};
};