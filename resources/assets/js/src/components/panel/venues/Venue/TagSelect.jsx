import React, {Component} from 'react';
import Select from 'react-select';
import 'react-select/dist/react-select.css';
import filter from 'lodash/filter'
import find from 'lodash/find';
import {searchTags} from '../../../../actions/index';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import getMuiTheme from 'material-ui/styles/getMuiTheme';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import Chip from 'material-ui/Chip';
import styles from '../../../../../../sass/components/panel/venues/TagSelect.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
class VenueOption extends Component {
		constructor(props) {
				super(props);
				this.handleClick = this.handleClick.bind(this);
				this.handleMouseEnter = this.handleMouseEnter.bind(this);
				this.handleMouseMove = this.handleMouseMove.bind(this);
		}

		handleClick(event) {
				event.preventDefault();
				event.stopPropagation();
				this.props.onSelect(this.props.option, event);
		}

		handleMouseEnter(event) {
				this.props.onFocus(this.props.option, event);
		}

		handleMouseMove(event) {
				if (this.props.isFocused) return;
				this.props.onFocus(this.props.option, event);
		}

		render() {
				return (
						<div className={this.props.className}
								 onMouseEnter={this.handleMouseEnter}
								 onClick={this.handleClick}
								 onMouseMove={this.handleMouseMove}
								 title={this.props.option.name}>
								<div className={cx('name')}>{this.props.option.name}</div>
						</div>
				);
		}
}
VenueOption.propTypes = {
		children: React.PropTypes.node,
		className: React.PropTypes.string,
		isDisabled: React.PropTypes.bool,
		isFocused: React.PropTypes.bool,
		isSelected: React.PropTypes.bool,
		onFocus: React.PropTypes.func,
		onSelect: React.PropTypes.func,
		option: React.PropTypes.object.isRequired,
};
class TagValue extends Component {

		render() {
				let theme = getMuiTheme(this.context.muiTheme, {
						isRtl: false,
						fontFamily: 'nazanin'
				});
				const styles = {
						chip: {
								margin: 2,
								direction: 'ltr',
								display: 'inline-flex'
						},
						wrapper: {
								display: 'flex',
								flexWrap: 'wrap',
						},
				};
				return (
						<MuiThemeProvider muiTheme={theme}>
								<Chip
										style={styles.chip}
								>
										{this.props.value.name}
								</Chip>
						</MuiThemeProvider>
				);
		}
}
class TagSelect extends Component {
		constructor(props) {
				super(props);
				this.state = {};
				this.setValue = this.setValue.bind(this);
		}

		setValue(value) {
				console.log('onchange');
				this.setState({value});
		}


		arrowRenderer() {
				return (
						<span>+</span>
				);
		}

		render() {
				let onInputChange = value=> {
						if (value.length > 0) {
								this.props.searchTags(value,this.props.slug);
						}
						return value;
				};
				var placeholder = <span>جستجوی تگها</span>;
				let filterOptions = (options, filters, currentValue)=> {
						return filter(options, (object, index, collection)=> {
								var found = find(currentValue, (o)=> {
										return o.slug == object.slug
								});
								return !found;
						})
				};
				let handleDelete = () => {
						this.setState({value: null})
				};

				let valueWrapper = function OptionWrapper(props) {
						return <TagValue {...props} option={props.value} handleDelete={handleDelete}/>;
				};
				return (
						<div className={cx('section')}>
								<Select
										arrowRenderer={this.arrowRenderer}
										isLoading={this.props.isLoading}
										options={this.props.venueTagsSearch}
										onInputChange={onInputChange}
										multi={false}
										filterOptions={filterOptions}
										noResultsText='هیچ تگی یافت نشد'
										placeholder={placeholder}
										onChange={this.setValue}
										value={this.state.value}
										optionComponent={VenueOption}
										valueComponent={valueWrapper}
										{...this.props.input}
										onBlur={()=>{this.props.input.onBlur(this.props.input.value)}}
								/>
								{this.props.showError && this.props.meta.invalid ?
										<div className={cx('error')}>{this.props.meta.error}</div> : ''}
						</div>
				);
		}
}
TagSelect.propTypes = {
		hint: React.PropTypes.string,
		label: React.PropTypes.string,
};


function mapStateToProps(state) {
		return {
				venueTagsSearch: state.venues.venueTagsSearch,
				isLoading: state.venues.isLoadingVenueTags,
		};
}
function mapDispatchToProps(dispatch) {
		return bindActionCreators({
				searchTags,
		}, dispatch);
}
let component = connect(mapStateToProps, mapDispatchToProps)(TagSelect);
module.exports = component;
export default component