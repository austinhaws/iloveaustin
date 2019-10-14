import isString from "lodash/isString";

export default (field, value) => value === undefined ? '' : `${field}: ${isString(value) ? `"${value}"` : value}`;
