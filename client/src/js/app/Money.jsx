export const toDollarString = amount => amount ? '$' + (parseFloat(amount) / 100.0).toFixed(2) : '$0.00';
