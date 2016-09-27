import React, {Component} from 'react';
import ReactDom from 'react-dom';
import Select from 'react-select';
import 'react-select/dist/react-select.css';
import filter from 'lodash/filter'
import find from 'lodash/find'
import {getCollectionVenues, setSelectedCollectionVenues} from '../../../../actions/index'
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import Chip from 'material-ui/Chip';
import getMuiTheme from 'material-ui/styles/getMuiTheme';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import styles from '../../../../../../sass/components/panel/collections/VenueSelect.scss';
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
                 id={this.props.option.slug}
                 title={this.props.option.name}>
                <div className={cx('name')}>{this.props.option.name}</div>
                <div className={cx('address')}>{this.props.option.address}</div>
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
class VenueValue extends Component {

    render() {
        let theme = getMuiTheme(this.context.muiTheme, {
            isRtl: false,
            fontFamily: 'nazanin'
        });
        const styles = {
            chip: {
                margin: 4,
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
                    onRequestDelete={()=>this.props.handleDelete(this.props.value.slug)}
                    id={this.props.value.slug}
                >
                    {this.props.value.name}
                </Chip>
            </MuiThemeProvider>
        );
    }
}
class VenueSelect extends Component {
    constructor(props) {
        super(props);
        this.state = {};
        this.setValue = this.setValue.bind(this);
    }

    componentDidMount() {
        let container = ReactDom.findDOMNode(this).parentNode;
        container.style.height = '300px'; //Used to make items in stepper visible.
    }

    setValue(value) {
        this.props.setSelectedCollectionVenues(value);
        this.props.input.onChange(value);
    }


    arrowRenderer() {
        return (
            <span>+</span>
        );
    }

    render() {
        let onInputChange = value=> {
            if (value.length > 0) {
                this.props.getCollectionVenues(this.props.collectionCity, value);
            }
            return value;
        };
        var placeholder = <span>جستجوی رستورانها</span>;
        let filterOptions = (options, filters, currentValue)=> {
            return filter(options, (object, index, collection)=> {
                var found = find(currentValue, (o)=> {
                    return o.slug == object.slug
                });
                return !found;
            })
        };
        let handleDelete = (slug) => {
            let deleted = filter(this.props.selectedCollectionVenues, (object)=> {
                return object.slug != slug;
            });
            this.props.setSelectedCollectionVenues(deleted);
        };

        let valueWrapper = function OptionWrapper(props) {
            return <VenueValue {...props} option={props.value} handleDelete={handleDelete}/>;
        };

        return (
            <div className="section">
                <Select
                    arrowRenderer={this.arrowRenderer}
                    isLoading={this.props.isLoading}
                    options={this.props.collectionVenues}
                    onInputChange={onInputChange}
                    multi={true}
                    filterOptions={filterOptions}
                    noResultsText='هیچ رستورانی یافت نشد'
                    placeholder={placeholder}
                    onChange={this.setValue}
                    value={this.props.selectedCollectionVenues}
                    optionComponent={VenueOption}
                    valueComponent={valueWrapper}
                />
                {this.props.showError && this.props.meta.invalid ?
                    <div className={cx('error')}>{this.props.meta.error}</div> : ''}
            </div>
        );
    }
}
VenueSelect.propTypes = {
    hint: React.PropTypes.string,
    label: React.PropTypes.string,
};


function mapStateToProps(state) {
    return {
        collectionVenues: state.collections.collectionVenues,
        selectedCollectionVenues: state.collections.selectedCollectionVenues,
        isLoading: state.collections.isLoadingCollectionVenues,
        collectionCity: state.collections.collectionCity
    };
}
function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        getCollectionVenues,
        setSelectedCollectionVenues
    }, dispatch);
}
let component = connect(mapStateToProps, mapDispatchToProps)(VenueSelect);
module.exports = component;
export default component