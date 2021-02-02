import {objectAtPath} from "@dts-soldel/dts-react-common";

export default {
	propertyChanged: (prevProps, props, path) => {
		const previous = objectAtPath(prevProps, path);
		const current = objectAtPath(props, path);
		return previous !== current;
	}
};
