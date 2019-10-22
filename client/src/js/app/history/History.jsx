import {dispatchField} from "../Dispatch";
import LocalStorage from "../localstorage/LocalStorage";

let history = undefined;

export default {
	forward: path => () => {
		dispatchField('app.historyPath', path);
		LocalStorage.path.set(path);
		history.push(path);
	},
	get: () => history,
	set: newHistory => history = newHistory,
}
