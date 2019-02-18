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
});
