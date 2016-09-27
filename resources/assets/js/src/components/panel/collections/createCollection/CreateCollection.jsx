import React, {Component} from'react';
const progress = require('nprogress');
import {Field, reduxForm, reset} from 'redux-form';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import{Step, Stepper, StepLabel, StepContent} from 'material-ui/Stepper';
import RaisedButton from 'material-ui/RaisedButton';
import FlatButton from 'material-ui/FlatButton';
import TextField from 'material-ui/TextField';
import Snackbar from 'material-ui/Snackbar';
import ExpandTransition from 'material-ui/internal/ExpandTransition';
import 'react-select/dist/react-select.css';
import CitySelect from './CitySelect';
import TypeSelect from './TypeSelect';
import styles from '../../../../../../sass/components/panel/collections/CreateCollection.scss'
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
import VenueSelect from './VenueSelect';

import {
    setModalType,
    setCollectionName,
    setCollectionDescription,
    setCollectionStartTime,
    setCollectionStartDate,
    setCollectionEndTime,
    setCollectionEndDate,
    setCollectionPhoto,
    getCollectionCities,
    setCollectionCity,
    setCollectionActivation,
    newCollection,
    setCollectionType,
    resetCollectionCreation,
    resetCollectionStates
} from '../../../../actions';
import CollectionDatePicker from './CollectionDatePicker';
import CollectionTimePicker from './CollectionTimePicker';
import CollectionPhotoUpload from './CollectionPhotoUpload';
import CollectionActivation from './CollectionActivation';

const TOTAL_STEP_COUNT = 4;
class CreateCollection extends Component {
    constructor(props) {
        super(props);
        this.state = {
            showError: false,
            stepIndex: 0,
            startTimeSelected: false,
            startDateSelected: false,
            endDisabled: true,
            showSnackbar: false,
            loading: false,
        };
        this.handleNext = this.handleNext.bind(this);
        this.handlePrev = this.handlePrev.bind(this);
        this.renderStepActions = this.renderStepActions.bind(this);
        this.handleFormSubmit = this.handleFormSubmit.bind(this);
    }

    handleFormSubmit({collectionName, collectionDescription, collectionType, citySlug, collectionPhoto, venueSelect, startTime, startDate, endTime, endDate, isActive}) {
        this.props.newCollection(collectionName, collectionDescription, collectionType, citySlug, collectionPhoto, venueSelect, startDate.getTime(), startTime.getTime(), endDate.getTime(), endTime.getTime(), isActive);
        this.props.reset();
        this.props.resetCollectionCreation();
        this.setState({
            stepIndex: 0,
            startTimeSelected: false,
            startDateSelected: false,
            endDisabled: true,
        });
    }

    dummyAsync = (cb) => {
        this.setState({loading: true}, () => {
            this.asyncTimer = setTimeout(cb, 300);
        });
    };

    handleNext() {
        const {stepIndex}=this.state;
        if (this.props.invalid)
            this.setState({
                showError: true
            });
        else if (stepIndex != TOTAL_STEP_COUNT) {
            this.setState({
                showError: false
            });
            if (!this.state.loading) {
                this.dummyAsync(() => this.setState({
                    loading: false,
                    stepIndex: stepIndex + 1
                }));
            }
        }
        return false;
    }

    handlePrev() {
        const {stepIndex} = this.state;
        if (stepIndex > 0)
            this.dummyAsync(() => this.setState({
                loading: false,
                stepIndex: stepIndex - 1
            }));
    }

    renderStepActions(step) {
        const {stepIndex} = this.state;
        return (
            <div style={{margin: '12px 0'}}>
                <RaisedButton
                    label={stepIndex == TOTAL_STEP_COUNT ? 'پایان' : 'بعدی'}
                    disableTouchRipple={true}
                    disableFocusRipple={true}
                    primary={true}
                    onTouchTap={this.handleNext}
                    type={stepIndex == TOTAL_STEP_COUNT ? 'submit' : 'button'}
                    style={{marginRight: 12}}/>
                {step > 0 && (
                    <FlatButton
                        label="قبلی"
                        disableTouchRipple={true}
                        disableFocusRipple={true}
                        onTouchTap={this.handlePrev}
                    />
                )}
            </div>
        )
    }

    renderStepContent() {
        const {stepIndex} =this.state;
        const minStartDate = new Date();
        minStartDate.setHours(0, 0, 0, 0);
        const maxStartDate = new Date();
        maxStartDate.setMonth(maxStartDate.getMonth() + 6);
        maxStartDate.setHours(0, 0, 0, 0);
        const minEndDate = new Date();
        const maxEndDate = new Date();
        let handleCollectionName = (param)=> {
            this.props.setCollectionName(param);
        };

        let handleCollectionDescription = (param)=> {
            this.props.setCollectionDescription(param);
        };
        let handleCollectionStartTime = (param)=> {
            this.props.setCollectionStartTime(param);
            this.setState({
                startTimeSelected: true,
                endDisabled: !this.state.startDateSelected,
            });
        };
        let handleCollectionStartDate = (param)=> {
            this.props.setCollectionStartDate(param);
            minEndDate.setUTCMilliseconds(param.getUTCMilliseconds());
            maxEndDate.setUTCMilliseconds(param.getUTCMilliseconds());
            maxEndDate.setMonth(maxEndDate.getMonth() + 1);
            this.setState({
                startDateSelected: true,
                endDisabled: !this.state.startTimeSelected,
                minEndDate,
                maxEndDate
            });
        };
        let handleCollectionEndTime = (param)=> {
            this.props.setCollectionEndTime(param);
        };
        let handleCollectionEndDate = (param)=> {
            this.props.setCollectionEndDate(param);
        };
        let handleCollectionPhoto = (files)=> {
            this.props.setCollectionPhoto(files.preview);
        };
        let handleCitySelect = (slug)=> {
            this.props.setCollectionCity(slug);
        };
        let handleCollectionTypeSelect = (id)=> {
            this.props.setCollectionType(id);
        };
        let handleCollectionActivation = (isActive)=> {
            this.props.setCollectionActivation(isActive);
        };
        if (stepIndex == 0) {
            return (
                <div>
                    <Field
                        component={collectionNameField}
                        onChange={handleCollectionName}
                        collectionName={this.props.collectionName}
                        showError={this.state.showError}
                        name="collectionName"/>
                    <Field
                        component={collectionDescriptionField}
                        onChange={handleCollectionDescription}
                        collectionDescription={this.props.collectionDescription}
                        name="collectionDescription"/>
                    {this.renderStepActions(0)}
                </div>
            )
        }
        else if (stepIndex == 1) {
            return (<div>
                <div>
                    <Field
                        component={CollectionDatePicker}
                        date={this.props.collectionStartDate}
                        onChange={handleCollectionStartDate}
                        withRef="access"
                        name="startDate"
                        id="startDate"
                        hintText="تاریخ شروع"
                        minDate={minStartDate}
                        maxDate={maxStartDate}
                        disabled={false}/>
                    <Field
                        component={CollectionTimePicker}
                        onChange={handleCollectionStartTime}
                        time={this.props.collectionStartTime}
                        name="startTime"
                        id="startTime"
                        disabled={false}
                        hintText="ساعت شروع"/>
                </div>
                <div>
                    <Field
                        component={CollectionDatePicker}
                        onChange={handleCollectionEndDate}
                        date={this.props.collectionEndDate}
                        name="endDate"
                        id="endDate"
                        hintText="تاریخ پایان"
                        disabled={this.state.endDisabled}
                        minDate={this.state.minEndDate}
                        maxDate={this.state.maxEndDate}/>
                    <Field
                        component={CollectionTimePicker}
                        onChange={handleCollectionEndTime}
                        time={this.props.collectionEndTime}
                        name="endTime"
                        id="endTime"
                        disabled={this.state.endDisabled}
                        hintText="ساعت پایان"/>
                </div>
                {this.props.invalid && this.state.showError &&
                <div className={cx('error')}>همه مقادیر ضرروری است</div>}
                {this.renderStepActions(1)}
            </div>)
        }
        else if (stepIndex == 2) {
            return (
                <div style={{height: '100%'}}>
                    <Field
                        id="collectionPhoto"
                        name="collectionPhoto"
                        onDrop={handleCollectionPhoto}
                        component={CollectionPhotoUpload}/>
                    {this.props.invalid && this.state.showError &&
                    <div className={cx('error')}>آیا میدانستید یک تصویر به هزار کلمه می ارزد؟</div>}
                    {this.renderStepActions(2)}
                </div>)
        }
        else if (stepIndex == 3) {
            return (<div>
                <Field component={CitySelect}
                       cities={this.props.cities}
                       id="citySlug"
                       name="citySlug"
                       showError={this.state.showError}
                       onChange={handleCitySelect}
                       city={this.props.collectionCity}/>

                <Field component={TypeSelect}
                       id="collectionType"
                       name="collectionType"
                       showError={this.state.showError}
                       onChange={handleCollectionTypeSelect}
                       type={this.props.collectionType}/>

                <Field
                    component={CollectionActivation}
                    default={this.props.isCollectionActive}
                    id="isActive"
                    name="isActive"
                    onToggle={handleCollectionActivation}/>
                {this.renderStepActions(3)}
            </div>)
        }
        else if (stepIndex == 4) {
            return (
                <div>
                    <Field component={VenueSelect} name="venueSelect" showError={this.state.showError}/>
                    {this.renderStepActions(4)}
                </div>)
        }
    }

    render() {
        const {handleSubmit} = this.props;
        return (
            <div>
                <form action="post" onSubmit={handleSubmit(this.handleFormSubmit.bind(this))}
                      ref="form">
                    <Stepper
                        activeStep={this.state.stepIndex}>
                        <Step>
                            <StepLabel>انتخاب اسم</StepLabel>
                        </Step>
                        <Step>
                            <StepLabel>تاریخ</StepLabel>
                        </Step>
                        <Step>
                            <StepLabel>تصویر</StepLabel>
                        </Step>
                        <Step>
                            <StepLabel>تنظیمات</StepLabel>
                        </Step>
                        <Step>
                            <StepLabel>انتخاب رستوران</StepLabel>
                        </Step>
                    </Stepper>
                    <ExpandTransition loading={this.state.loading} open={true}>
                        {this.renderStepContent()}
                    </ExpandTransition>
                </form>
                <Snackbar
                    open={this.state.showSnackbar}
                    message="کلکسیون ساخته شد"
                    autoHideDuration={3000}
                    onRequestClose={this.handleRequestClose}
                />
            </div>
        )
    }

    componentDidMount() {
        progress.done();
        if (!this.props.cities) {
            this.props.getCollectionCities();
            progress.start();
        }
        if (this.props.isModal) {
            this.props.setModalType('CreateCollection')
        }
    }

    componentWillUnmount() {
        console.log('unmounting');
        this.props.reset();
        this.props.resetCollectionCreation();
        this.setState({
            stepIndex: 0,
            startTimeSelected: false,
            startDateSelected: false,
            endDisabled: true,
        });
    }

    componentDidUpdate() {
        if (!this.props.hasCreatedCollection && this.props.isCreatingCollection) {
            progress.start();
        }
        if (this.props.hasCreatedCollection && !this.props.isCreatingCollection) {
            progress.done();
            this.setState({showSnackbar: true});
            this.props.resetCollectionStates();
            this.props.getCollectionCities();
            let windowThis = this;
            setTimeout(()=> {
                windowThis.setState({showSnackbar: false});
            }, 3000);
        }
        if (this.props.cities)
            progress.done();
    }
}
const validate = values => {
    const errors = {};
    if (!values.collectionName) {
        errors.collectionName = 'ضروری'
    }
    if (!values.startTime) {
        errors.startTime = 'ضروری';
    }
    if (!values.startDate) {
        errors.startDate = 'ضروری';
    }
    if (!values.endTime) {
        errors.endTime = 'ضروری';
    }
    if (!values.endDate) {
        errors.endDate = 'ضروری';
    }
    if (!values.collectionCity) {
        errors.collectionCity = 'ضروری'
    }
    if (!values.collectionPhoto) {
        errors.collectionPhoto = 'ضروری'
    }
    else if (values.collectionPhoto.size > CollectionPhotoUpload.maxSize) {
        errors.collectionPhoto = 'فایل آپلودی نمی تواند بیشتر از پنج مگابایت باید'
    }
    if (!values.citySlug) {
        errors.citySlug = 'ضروری'
    }
    if (!values.collectionType) {
        errors.collectionType = 'ضروری';
    }
    if (!values.venueSelect) {
        errors.venueSelect = 'حداقل یک رستوران باید اضافه شود';
    }
    return errors
};
const collectionNameField = props=> {
    let meta = props.meta;
    let hasCollectionNameError = props.showError && meta.invalid;
    let handleChange = (e)=> {
        var param = e.target.value;
        props.onChange(param);
        props.input.onChange(param)
    };
    return (
        <div>
            <TextField
                id='collectionName'
                floatingLabelText="اسم کلکسیون*"
                onChange={handleChange}
                value={props.collectionName ? props.collectionName : ''}
                errorText={hasCollectionNameError ? 'ضروری' : ''}
            />
        </div>)
};
const collectionDescriptionField = (props)=> {
    let handleChange = (e)=> {
        var param = e.target.value;
        props.onChange(param);
        props.input.onChange(param)
    };
    return (
        <div>
            <TextField
                id='collectionDescription'
                onChange={handleChange}
                value={props.collectionDescription ? props.collectionDescription : ''}
                floatingLabelText="توضیحات کلکسیون"/>
        </div>
    )
};
function mapStateToProps(state) {
    return {
        isModal: state.modals.isModal,
        collectionName: state.collections.collectionName,
        collectionDescription: state.collections.collectionDescription,
        collectionStartTime: state.collections.collectionStartTime,
        collectionStartDate: state.collections.collectionStartDate,
        collectionEndTime: state.collections.collectionEndTime,
        collectionEndDate: state.collections.collectionEndDate,
        collectionPhoto: state.collections.collectionPhoto,
        collectionStep: state.collections.collectionStep,
        cities: state.collections.cities,
        collectionCity: state.collections.collectionCity,
        isCollectionActive: state.collections.isCollectionActive,
        isCreatingCollection: state.collections.isCreatingCollection,
        hasCreatedCollection: state.collections.hasCreatedCollection,
        collectionType: state.collections.collectionType
    };
}
function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        setModalType,
        setCollectionName,
        setCollectionDescription,
        setCollectionStartTime,
        setCollectionStartDate,
        setCollectionEndTime,
        setCollectionEndDate,
        setCollectionPhoto,
        getCollectionCities,
        setCollectionCity,
        setCollectionActivation,
        newCollection,
        setCollectionType,
        resetCollectionCreation,
        resetCollectionStates
    }, dispatch);
}
module.exports = connect(mapStateToProps, mapDispatchToProps)(reduxForm({
    form: 'createCollection',
    fields: ['collectionName', 'collectionDescription', 'citySlug', 'startDate', 'startTime', 'endDate', 'endTime', 'collectionPhoto', 'venueSelect', 'isActive', 'collectionType'],
    validate
})(CreateCollection));
