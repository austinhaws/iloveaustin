export const toDollarString = amount => amount ? '$' + (parseFloat(amount) / 100.0).toFixed(2) : '$0.00';

export const fromDollarString = amountStr => {
	let parts = (amountStr || '').split(/\./);
	if (parts.length === 1) {
		parts[1] = '00';
	}

	if (parts[1].length === 1) {
		parts[1] += '0';
	}
	parts[1] = parts[1].substr(0, 2);

	return Number(parts.join('').replace('\$', ''));
};
