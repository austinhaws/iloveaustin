import '@babel/polyfill';
import React from 'react';
import MaskedInput from "react-text-mask";
import Masks from "../../app/masks/Masks";

export default props => {
	// getting errors about inputRef not being valid
	const {inputRef, ...rest} = props;
	return <MaskedInput mask={Masks.dateMask} {...rest}/>;
};
