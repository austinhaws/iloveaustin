import '@babel/polyfill';
import React from 'react';
import AppBar from "@material-ui/core/AppBar";
import Toolbar from "@material-ui/core/Toolbar";
import IconButton from "@material-ui/core/IconButton";
import MenuIcon from '@material-ui/icons/Menu';
import Typography from "@material-ui/core/Typography";
import {withStyles} from "@material-ui/core";
import Popper from "@material-ui/core/Popper";
import Grow from "@material-ui/core/Grow";
import Paper from "@material-ui/core/Paper";
import ClickAwayListener from "@material-ui/core/ClickAwayListener";
import MenuList from "@material-ui/core/MenuList";
import MenuItem from "@material-ui/core/MenuItem";
import Pages from "./Pages";
import Button from "@material-ui/core/Button";
import {withRouter} from "react-router-dom";
import * as PropTypes from "prop-types";
import GoogleLogin from "react-google-login";
import {connect} from "react-redux";
import LocalStorage from "./localstorage/LocalStorage";
import Account from "./account/Account";

const propTypes = {
	app: PropTypes.object,
};
const defaultProps = {
	app: undefined,
};

const mapStateToProps = state => ({app: state.app});

const styles = {
	root: {
		flexGrow: 1,
	},
	grow: {
		flexGrow: 1,
	},
	menuButton: {
		marginLeft: -12,
		marginRight: 20,
	},
	navMenu: {
		backgroundColor: '#a9c2ff',
	},
	rpggenerator: {
		color: 'black',
	},
	loggedInUserContent: {
		float: 'right',
	},
};

class MainAppBar extends React.Component {
	state = {
		open: false,
	};

	componentDidMount() {
		const tokenId = LocalStorage.googleTokenId.get();
		tokenId && this.signInWithTokenId(tokenId);
	}

	signInWithTokenId = tokenId => Account.signIn(tokenId)
		.then(Pages.iLoveAustin.budget.forward);

	handleToggle = () => {
		this.setState(state => ({ open: !state.open }));
	};

	handleClose = () => {
		this.setState({ open: false });
	};

	handleMenuItem = url => {
		return event => {
			this.handleClose(event);
			window.location = url;
		};
	};

	responseGoogle = googleResponse => googleResponse.tokenId && this.signInWithTokenId(googleResponse.tokenId);

	render() {
		const { classes } = this.props;
		const { open } = this.state;

		return (
			<div className={classes.root}>
				<AppBar position="static">
					<Toolbar>
						<IconButton
							className={classes.menuButton}
							color="inherit"
							aria-label="Menu"
							buttonRef={node => this.anchorEl = node}
							onClick={this.handleToggle}
						>
							<MenuIcon
								aria-owns={open ? 'menu-list-grow' : undefined}
								aria-haspopup="true"
							/>
						</IconButton>
						<Popper open={open} anchorEl={this.anchorEl} transition disablePortal>
							{({ TransitionProps, placement }) => (
								<Grow
									{...TransitionProps}
									id="menu-list-grow"
									style={{ transformOrigin: placement === 'bottom' ? 'center top' : 'center bottom' }}
								>
									<Paper>
										<ClickAwayListener onClickAway={this.handleClose}>
											<MenuList>
												<MenuItem onClick={this.handleMenuItem('http://rpggenerator.com')}>RPG Generator</MenuItem>
											</MenuList>
										</ClickAwayListener>
									</Paper>
								</Grow>
							)}
						</Popper>


						<Typography variant="h6" color="inherit" className={classes.grow}>I Love Austin</Typography>
						{this.props.app.account ?
							<div className={classes.loggedInUserContent}>
								Welcome, {this.props.app.account.nickname}
								<Button className={classes.signOutButton} onClick={Account.signOut}>Sign Out</Button>
							</div>
							:
							<GoogleLogin
								clientId="306725008311-l4rt8a9edu84ru378h285msmtmtgn9k1.apps.googleusercontent.com"
								buttonText="Sign In"
								onSuccess={this.responseGoogle}
								onFailure={console.error}
								cookiePolicy={'single_host_origin'}
							/>
						}

					</Toolbar>
					<Toolbar className={classes.navMenu}>
						<Button onClick={Pages.iLoveAustin.budget.forward}>Budget</Button>
						<Button onClick={Pages.iLoveAustin.savings.forward}>Savings</Button>
					</Toolbar>
				</AppBar>
			</div>
		);
	}
}

MainAppBar.propTypes = propTypes;
MainAppBar.defaultProps = defaultProps;

export default withRouter(connect(mapStateToProps)(withStyles(styles)(MainAppBar)));
