let history = undefined;

export default {
	get: () => history,
	set: newHistory => history = newHistory,
}
