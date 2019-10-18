import isString from "lodash/isString";

// note that """ means multi-line string in GraphQL
export default (field, value) => value === undefined ? '' : `${field}: ${isString(value) ? `"""${value}"""` : value}`;
