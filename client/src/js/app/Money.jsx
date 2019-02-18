export const toDollarString = amount => amount ? '$' + (parseFloat(amount) / 100.0).toFixed(2) : '$0.00';

export const fromDollarString = amountStr => {
	let parts = (amountStr || '').split(/\./);
	parts[0] = parts[0].replace(/\$/, '');

	if (parts.length === 1) {
		parts[1] = '00';
	}

	parts[1] = parts[1].padEnd(2, '0').substr(0, 2);

	return Number(parts.join('').replace('\$', ''));
};
