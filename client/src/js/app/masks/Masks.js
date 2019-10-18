import createNumberMask from 'text-mask-addons/dist/createNumberMask'

export default {
	moneyMask: createNumberMask({
		prefix: '$',
		allowDecimal: true,
		requireDecimal: true,
	}),
};
