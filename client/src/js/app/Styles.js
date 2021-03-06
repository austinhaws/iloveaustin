import green from "@material-ui/core/colors/green";

export default theme => ({
	root: {
		display: 'flex',
		flexWrap: 'wrap',
		flexDirection: 'column',
		margin: '0 auto',
	},
	addButton: {
		margin: '0 auto',
		borderColor: '#64991e',
		color: '#64991e',
		marginBottom: '10px',
	},
	bodyTableRow: {
		cursor: 'pointer',
	},
	formControl: {
		margin: theme.spacing.unit,
		minWidth: 120,
	},
	sectionTitle: {
		textAlign: 'center',
	},
	selectEmpty: {
		marginTop: theme.spacing.unit * 2,
	},
	buttonProgress: {
		color: green[500],
		position: 'absolute',
		top: '50%',
		left: '50%',
		marginTop: -12,
		marginLeft: -12,
	},
	slider: {
		padding: '22px 0px',
	},
	table: {
		minWidth: 700,
	},
	inputSizeSmall: {
		width: '50px',
	},
	inputSizeMedium: {
		width: '100px',
	},
	textAlignCenter: {
		textAlign: 'center'
	},
	dateTimePickerInput: {
		marginRight: '6px',
	},
	addActionButton: {
		width: '50%',
		margin: '7px auto',
	},
	spacer: {
		flex: '1 1 100%',
	},
	toolbarMonthlyDatePicker: {
		marginTop: '11px',
	},
	dialogCloseButton: {
		position: 'absolute',
		right: theme.spacing.unit,
		top: theme.spacing.unit,
		color: theme.palette.grey[500],
	},
	popover: {
		pointerEvents: 'none',
	},
	popoverPaper: {
		padding: theme.spacing.unit,
	},
	renderLineBreaks: {
		whiteSpace: 'pre-line',
	},
	tableCellTextIcon: {
		width: '.75em',
		position: 'relative',
		top: '-7px',
		left: '5px',
	},
	tableSpacer: {
		height: '50px',
	},
	textFieldSelect: {
		marginTop: '23px',
	},
	redColor: {
		color: 'red !important',
	},
	bankBalanceTitle: {
		textAlign: 'center',
		fontSize: '1.5em',
		padding: '25px 0',
	},
	navBarSpacer: {
		height: '12px',
		width: '100%',
	},
});
