import '@babel/polyfill';
import React from 'react';
import Button from '@material-ui/core/Button';
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
	rpggenerator: {
		color: 'black',
	},
};

class MainAppBar extends React.Component {
	state = {
		open: false,
	};

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
						>
							<MenuIcon
								aria-owns={open ? 'menu-list-grow' : undefined}
								aria-haspopup="true"
								onClick={this.handleToggle}
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
												<MenuItem onClick={this.handleMenuItem('http://rpggenerator.com')}>About Us</MenuItem>
												<MenuItem onClick={this.handleMenuItem('http://strategerygames.com/centralcasting')}>Character Generator</MenuItem>
											</MenuList>
										</ClickAwayListener>
									</Paper>
								</Grow>
							)}
						</Popper>


						<Typography variant="h6" color="inherit" className={classes.grow}>I Love Austin</Typography>
						<Button color="inherit" onClick={() => alert('Coming Soon!')}>Login</Button>
					</Toolbar>
				</AppBar>
			</div>
		);
	}
}

export default withStyles(styles)(MainAppBar);
