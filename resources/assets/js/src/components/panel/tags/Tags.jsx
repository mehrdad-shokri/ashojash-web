import React from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import {newTag, getTags, tagError, resetTagStatus} from '../../../actions'
const progress = require('nprogress');
import styles from '../../../../../sass/components/panel/tags/Tags.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
import findIndex from 'lodash/findIndex';
import trim from 'lodash/trim';
import {TAG_EXISTS_ERROR} from '../../../actions/tag_actions';
import {
		Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn
}    from 'material-ui/Table';
import Snackbar from 'material-ui/Snackbar';

class Tags extends React.Component {

		constructor(props) {
				super(props);

				this.state = {
						height: '300px',
						currentTag: "",
						showSnackbar: false,
						showedSnackbar: false
				};
				this.handleSubmit = this.handleSubmit.bind(this);
				this.handleTagChange = this.handleTagChange.bind(this);
		}

		handleTagChange(e) {
				this.setState({currentTag: e.target.value});
		}

		handleSubmit(e) {
				e.preventDefault()
				var tag = trim(this.state.currentTag);
				var index = findIndex(this.props.tags, (item)=> {
						return item.name == tag;
				});
				if (tag) {
						if (index < 0) {
								this.setState({currentTag: ""});
								var tagObject = {name: tag, level: 1}
								this.props.newTag(tag, 1);
								this.props.tags.unshift(tagObject);
						}
						else {
								this.props.tagError(TAG_EXISTS_ERROR);
						}
				}
		}

		componentDidMount() {
				if (!this.props.hasTags) {
						progress.start();
						this.props.getTags();
				}
		}

		componentDidUpdate() {
				if (!this.props.isRequesting && (this.props.hasTags || this.props.hasError)) {
						progress.done();
				}
		}

		render() {
				return (
						<div>
								{!this.props.isRequesting && this.props.hasTags ? <form action="" onSubmit={this.handleSubmit}>
										<input type="text"
													 onChange={this.handleTagChange}
													 value={this.state.currentTag}
													 placeholder="تگ را وارد کنید"
													 className={cx('tagSelect')}/>
								</form> : <span></span>}
								<Table
										height={this.state.height}
										fixedHeader={true}>
										<TableHeader
												displaySelectAll={false}
												adjustForCheckbox={false}
										>
												<TableRow>
														<TableHeaderColumn tooltip="نام تگ" style={{fontSize: 18}}
																							 tooltipStyle={{fontSize: 13}}>نام</TableHeaderColumn>
														<TableHeaderColumn tooltip="آیکون تگ را برای آپلود اینجا بکشید"
																							 tooltipStyle={{fontSize: 13}}
																							 style={{fontSize: 18}}>آیکون</TableHeaderColumn>
														<TableHeaderColumn tooltip="سطح کمتر، اولیت بالاتری در جستجو دارد"
																							 tooltipStyle={{fontSize: 13}}
																							 style={{fontSize: 18}}>سطح</TableHeaderColumn>

												</TableRow>
										</TableHeader>
										<TableBody displayRowCheckbox={false}>
												{
														this.props.tags ? this.props.tags.map((item, index)=> {
																return (
																		<TableRow key={index} selectable={false}>
																				<TableRowColumn style={{fontSize: 15}}>{item.name}</TableRowColumn>
																				<TableRowColumn style={{fontSize: 15}}>{item.level}</TableRowColumn>
																				<TableRowColumn style={{fontSize: 15}}></TableRowColumn>
																		</TableRow>
																)
														}) : ""
												}
										</TableBody>
								</Table>
								<Snackbar
										open={this.props.createdTag || this.props.hasError}
										message={this.props.errorMessage ? this.props.errorMessage : "تگ ساخته شد"}
										autoHideDuration={3000}
										onRequestClose={()=> {
												this.props.resetTagStatus();
										}}
								/>
						</div>
				);
		}
}
function mapDispatchToProps(dispatch) {
		return bindActionCreators({
				getTags: getTags,
				newTag: newTag,
				tagError: tagError,
				resetTagStatus: resetTagStatus
		}, dispatch);
}

function mapStateToProps(state) {
		return {
				isRequesting: state.tags.isRequesting,
				tags: state.tags.tags,
				hasTags: state.tags.hasTags,
				hasError: state.tags.hasError,
				errorMessage: state.tags.errorMessage,
				createdTag: state.tags.createdTag,
				isCreatingTag: state.tags.isCreatingTag
		};
}
export default connect(mapStateToProps, mapDispatchToProps)(Tags);
module.exports = connect(mapStateToProps, mapDispatchToProps)(Tags);