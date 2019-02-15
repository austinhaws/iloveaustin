import '@babel/polyfill';
import React from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {TextField, withStyles} from "@material-ui/core";
import {dispatchField, dispatchFieldCurry} from "../util/Dispatch";
import * as PropTypes from "prop-types";
import Select from "@material-ui/core/Select";
import webservice, {ajaxStatus} from "../util/Webservice";
import MenuItem from "@material-ui/core/MenuItem";
import InputLabel from "@material-ui/core/InputLabel";
import FormControl from "@material-ui/core/FormControl";
import FormHelperText from "@material-ui/core/es/FormHelperText/FormHelperText";
import Button from "@material-ui/core/Button";
import CircularProgress from "@material-ui/core/CircularProgress";
import green from '@material-ui/core/colors/green';
import Slider from '@material-ui/lab/Slider';

const propTypes = {
	citygen: PropTypes.object.isRequired,
	history: PropTypes.object.isRequired,
};
const defaultProps = {};
const mapStateToProps = state => ({ citygen: state.citygen });

const styles = theme => ({
	root: {
		display: 'flex',
		flexWrap: 'wrap',
		flexDirection: 'column',
		width: '250px',
		margin: '0 auto',
	},
	formControl: {
		margin: theme.spacing.unit,
		minWidth: 120,
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
});

class CityGenForm extends React.Component {
	componentDidMount() {
		// get lists if missing
		if (!this.props.citygen.lists.populationTypes) {
			webservice.citygen.lists();
		}
	}

	menuItemsFromList = list => {
		return [<MenuItem key="Random" value="Random">Random</MenuItem>]
			.concat((list || []).map(item => <MenuItem key={item.id} value={item.id}>{item.label}</MenuItem>));
	};

	generate = () => {
		webservice.citygen.generate(this.props.citygen.form)
			.then(() => this.props.history.push('/generated'));
	};

	addCustomWard = () => {

		// add a custom ward entry and fill it with its buildings
		const ward = this.props.citygen.inputs.customWard;
		const buildings = this.props.citygen.lists.buildingsByWard[ward];
		const buildingsList = buildings.map(ward => ({ type: ward, weight: '1' }));
		const wardDetail = {
			ward: ward,
			buildings: buildingsList,
		};

		// reset menu & push new ward detail
		dispatchField('citygen.inputs.customWard', '');
		dispatchField(`citygen.form.wardsAdded.${this.props.citygen.form.wardsAdded.length}`, wardDetail);
	};

	render() {
		const { classes } = this.props;
		const ajaxing = ajaxStatus.isAjaxing();

		const randomMenuItems = this.props.citygen.lists.booleanRandomValues ?
			Object.keys(this.props.citygen.lists.booleanRandomValues).map(key => <MenuItem key={key} value={this.props.citygen.lists.booleanRandomValues[key]}>{this.props.citygen.lists.booleanRandomValues[key]}</MenuItem>) :
			undefined;


		return (
			<React.Fragment>
				<div className={classes.root}>
					{/* Name */}
					<FormControl className={classes.formControl}>
						<TextField
							label="Name"
							autoFocus={true}
							onChange={dispatchFieldCurry('citygen.form.name')}
							placeholder="Random"
							value={this.props.citygen.form.name}
							disabled={ajaxing}
							inputProps={{ id: 'name', shrink: 'shrink' }}
							helperText={this.props.citygen.form.name === 'Custom' ? "Translated to the majority race language" : ''}
						/>
					</FormControl>

					{/* Population Type */}
					<FormControl className={classes.formControl}>
						<InputLabel shrink htmlFor="populationType">Population</InputLabel>
						<Select
							value={this.props.citygen.form.populationType}
							onChange={dispatchFieldCurry('citygen.form.populationType')}
							inputProps={{ id: 'populationType' }}
							disabled={ajaxing}
						>
							{this.menuItemsFromList(this.props.citygen.lists.populationTypes)}
							<MenuItem key="gi" value="45000">Gargantuan I (45,000)</MenuItem>
							<MenuItem key="gii" value="55000">Gargantuan II (55,000)</MenuItem>
							<MenuItem key="giii" value="65000">Gargantuan III (65,000)</MenuItem>
							<MenuItem key="giv" value="75000">Gargantuan IV (75,000)</MenuItem>
							<MenuItem key="gv" value="85000">Gargantuan V (85,000)</MenuItem>
						</Select>
					</FormControl>

					{/* By the Sea */}
					<FormControl className={classes.formControl}>
						<InputLabel shrink htmlFor="byTheSea">By the Sea</InputLabel>
						<Select
							value={this.props.citygen.form.sea}
							onChange={dispatchFieldCurry('citygen.form.sea')}
							inputProps={{ id: 'byTheSea' }}
							disabled={ajaxing}
						>
							{randomMenuItems}
						</Select>
					</FormControl>

					{/* By the River */}
					<FormControl className={classes.formControl}>
						<InputLabel shrink htmlFor="byTheRiver">By the River</InputLabel>
						<Select
							value={this.props.citygen.form.river}
							onChange={dispatchFieldCurry('citygen.form.river')}
							inputProps={{ id: 'byTheRiver' }}
							disabled={ajaxing}
						>
							{randomMenuItems}
						</Select>
					</FormControl>

					{/* Has Military */}
					<FormControl className={classes.formControl}>
						<InputLabel shrink htmlFor="military">Has Military</InputLabel>
						<Select
							value={this.props.citygen.form.military}
							onChange={dispatchFieldCurry('citygen.form.military')}
							inputProps={{ id: 'military' }}
							disabled={ajaxing}
						>
							{randomMenuItems}
						</Select>
					</FormControl>

					{/* # Gates */}
					<FormControl className={classes.formControl}>
						<InputLabel shrink htmlFor="gates">Number of Gates</InputLabel>
						<Select
							value={this.props.citygen.form.gates}
							onChange={dispatchFieldCurry('citygen.form.gates')}
							inputProps={{ id: 'gates' }}
							disabled={ajaxing}
						>
							<MenuItem key="Random" value="Random">Random</MenuItem>
							{Array(11).fill(false).map((_, i) => <MenuItem key={i} value={i}>{i}</MenuItem>)}
						</Select>
						<FormHelperText>At least one gate means city has walls</FormHelperText>
					</FormControl>

					{/* # Professions */}
					<FormControl className={classes.formControl}>
						<InputLabel shrink htmlFor="professions">Generate Professions</InputLabel>
						<Select
							value={this.props.citygen.form.professions}
							onChange={dispatchFieldCurry('citygen.form.professions')}
							inputProps={{ id: 'professions' }}
							disabled={ajaxing}
						>
							<MenuItem key="Yes" value="Yes">Yes</MenuItem>
							<MenuItem key="No" value="No">No</MenuItem>
						</Select>
					</FormControl>

					{/* # Buildings */}
					<FormControl className={classes.formControl}>
						<InputLabel shrink htmlFor="buildings">Generate Buildings</InputLabel>
						<Select
							value={this.props.citygen.form.buildings}
							onChange={dispatchFieldCurry('citygen.form.buildings')}
							inputProps={{ id: 'buildings' }}
							disabled={ajaxing}
						>
							<MenuItem key="Yes" value="Yes">Yes</MenuItem>
							<MenuItem key="No" value="No">No</MenuItem>
							<MenuItem key="custom" value="custom">Custom Wards</MenuItem>
						</Select>
					</FormControl>

					{/* Custom Wards */}
					{
						this.props.citygen.form.buildings === 'custom' ?
							<FormControl className={classes.formControl}>
								<Select
									value={this.props.citygen.inputs.customWard}
									onChange={dispatchFieldCurry('citygen.inputs.customWard')}
									inputProps={{ id: 'customWard' }}
									disabled={ajaxing}
									placeholder="Choose Ward Type"
								>
									{this.props.citygen.lists.wards.map(ward => (
										<MenuItem key={ward.id} value={ward.label}>{ward.label}</MenuItem>
									))};
								</Select>
								<Button
									variant="contained"
									color="primary"
									onClick={this.addCustomWard}
									disabled={ajaxing || !this.props.citygen.inputs.customWard}
								>
									Add Ward
								</Button>
								<div className="custom_wards">
									{this.props.citygen.form.wardsAdded.map((wardAdded, wardIdx) => (
										<div className="custom_wards--ward" key={`${wardAdded}-${wardIdx}`}>
											<div className="custom_wards--ward--name">{wardAdded.ward}</div>
											<div className="custom_wards--ward--buildings">
												{wardAdded.buildings.map((building, buildingIdx) => (
													<FormControl className="custom_wards--ward--building" key={building.type}>
														<TextField
															label={building.type}
															autoFocus={true}
															onChange={dispatchFieldCurry(`citygen.form.wardsAdded.${wardIdx}.buildings.${buildingIdx}.weight`)}
															value={building.weight}
															disabled={ajaxing}
															inputProps={{ shrink: 'shrink' }}
														/>
													</FormControl>
												))}
											</div>
										</div>
									))}
								</div>
							</FormControl>
							: undefined
					}

					{/* Society Racial Type */}
					<FormControl className={classes.formControl}>
						<InputLabel shrink htmlFor="racialMix">Society Type</InputLabel>
						<Select
							value={this.props.citygen.form.racialMix}
							onChange={dispatchFieldCurry('citygen.form.racialMix')}
							inputProps={{ id: 'racialMix' }}
							disabled={ajaxing}
						>
							{this.menuItemsFromList(this.props.citygen.lists.integration)}
						</Select>
					</FormControl>
					{
						this.props.citygen.form.racialMix === 'Custom' ? (
							/* Race ratio sliders */
							<FormControl className={classes.formControl}>
								<InputLabel shrink>Race Proportions</InputLabel>
								{
									this.props.citygen.lists.race.map(race => {
										const raceRatioIdx = this.props.citygen.form.raceRatios.findIndex(ratio => ratio.race === race.id);
										return (<FormControl className={classes.formControl} key={race.id}>
											<InputLabel htmlFor={`race-slider-${race.id}`}>{race.label}</InputLabel>
											<Slider
												id={`race-slider-${race.id}`}
												classes={{container: classes.slider}}
												value={raceRatioIdx === -1 ? 0 : this.props.citygen.form.raceRatios[raceRatioIdx].ratio}
												aria-labelledby="label"
												onChange={(control, value) => {
													if (raceRatioIdx === -1) {
														dispatchField(`citygen.form.raceRatios.${this.props.citygen.form.raceRatios.length}`, { race: race.id, ratio: value });
													} else {
														dispatchField(`citygen.form.raceRatios.${raceRatioIdx}.ratio`, value);
													}
												}}
												disabled={ajaxing}
											/>
										</FormControl>);
									})
								}
							</FormControl>
						) : (
							/* Major Race */
							<FormControl className={classes.formControl}>
								<InputLabel shrink htmlFor="race">Major Race</InputLabel>
								<Select
									value={this.props.citygen.form.race}
									onChange={dispatchFieldCurry('citygen.form.race')}
									inputProps={{id: 'race'}}
									disabled={ajaxing}
								>
									{this.menuItemsFromList(this.props.citygen.lists.race)}
								</Select>
							</FormControl>
						)
					}


					{/* Generate Button */}
					<FormControl className={classes.formControl}>
						<Button
							variant="contained"
							color="primary"
							onClick={this.generate}
							disabled={ajaxing}
						>
							Generate
						</Button>
						{ajaxing && <CircularProgress size={24} className={classes.buttonProgress} />}
					</FormControl>
				</div>
			</React.Fragment>
	);
	}
}

CityGenForm.propTypes = propTypes;
CityGenForm.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(CityGenForm)));
