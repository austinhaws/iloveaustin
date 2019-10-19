export const toDollarString = amount => amount ? '$' + (parseFloat(amount) / 100.0).toFixed(2) : '$0.00';

export const fromDollarString = amountStr => {
console.error('use of DEPRECATED formatDollarString - use toDirtyMoney instead');
	let parts = (amountStr || '').split(/\./);
	parts[0] = parts[0].replace(/\$/, '');

	if (parts.length === 1) {
		parts[1] = '00';
	}

	parts[1] = parts[1].padEnd(2, '0').substr(0, 2);

	return Number(parts.join('').replace('\$', ''));
};

export const addPlainMoney = (plainMoney1, plainMoney2) => `${(parseInt(plainMoney1, 10) || 0) + (parseInt(plainMoney2, 10) || 0)}`;

/**
 * strip $ and decimal point so it's just numbers with two 00s at end for cents
 *
 * @param dirtyMoney (ie. $641.32 or $640.3 or $640 or 6)
 * @return {string} (ie 64132 or 64030 or 64000 or 600)
 */
export const toPlainMoney = dirtyMoney => {
	// make sure it has two trailing 0s
	const parts = (dirtyMoney || '').split('.');
	// for sure has at least a blank string in the first index of parts
	if (parts.size < 2) {
		parts.push('00');
	} else {
		parts[1] = _.padEnd(parts[1], 2, '0');
	}
	if (parts[0].length < 1) {
		parts[1] = '0';
	}
	if (parts[1].length > 2) {
		parts[1] = parts[1].substr(0, 2);
	}

	// put it back together as plain money
	return parts.join('').replace(/[^\d]/g, '');
};

export const toDirtyMoney = money => {
	// make sure plain money has all its digits
	const moneyStr = `${money}`;
	const plainMoney = ((moneyStr && moneyStr.length < 3) ? _.padStart(moneyStr, 3, '0') : moneyStr) || '000';
	// convert to $ decimal string
	return '$' + plainMoney.substr(0, plainMoney.length - 2) + '.' + plainMoney.substr(plainMoney.length - 2);
};
