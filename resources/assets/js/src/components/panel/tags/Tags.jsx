import React from 'react';
import {connect} from 'react-redux';
import {bindActionCreators} from 'redux';
import {newTag, getTags, tagMessage, uploadFile, resetTagStatus} from '../../../actions'
const progress = require('nprogress');
import styles from '../../../../../sass/components/panel/tags/Tags.scss';
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
const DropZone = require('react-dropzone');
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
				};
				this.handleSubmit = this.handleSubmit.bind(this);
				this.handleTagChange = this.handleTagChange.bind(this);
				this.onDrop = this.onDrop.bind(this);
		}

		handleTagChange(e) {
				this.setState({currentTag: e.target.value});
		}

		handleSubmit(e) {
				e.preventDefault();
				var tag = trim(this.state.currentTag);
				var index = findIndex(this.props.tags, (item)=> {
						return item.name == tag;
				});
				if (tag) {
						if (index < 0) {
								this.setState({currentTag: ""});
								var tagObject = {name: tag, level: 1};
								this.props.newTag(tag, 1);
								this.props.tags.unshift(tagObject);
						}
						else {
								this.props.tagMessage(TAG_EXISTS_ERROR);
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
				if (!this.props.isRequesting && (this.props.hasTags || this.props.hasMessage)) {
						progress.done();
				}
				if(this.props.uploadedTagPhoto)
				{
						this.props.getTags();
				}
		}

		onDrop(files, id) {
				this.props.uploadFile(files[0], id);
		};

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
														this.props.tags ? this.props.tags.map((item)=> {
																return (
																		<TableRow key={item.id} selectable={false}>
																				<TableRowColumn style={{fontSize: 15}}>{item.name}</TableRowColumn>
																				<TableRowColumn style={{fontSize: 15}}>
																						<DropZone multiple={false}
																											accept="image/*"
																											className={cx("dropzone")}
																											onDrop={(files)=>this.onDrop(files, item.id)}
																											maxSize={5000000}>
																								{item.photo ? <img
																										src={item.photo.url}
																										alt=""/> : <img
																										src={require('../../../../../statics/img/components/panel/tags/upload.png')}
																										alt=""/>}
																						</DropZone>
																				</TableRowColumn>
																				<TableRowColumn style={{fontSize: 15}}>{item.level}</TableRowColumn>

																		</TableRow>
																)
														}) : ""
												}
										</TableBody>
								</Table>
								<Snackbar
										open={this.props.createdTag || this.props.hasMessage || this.props.uploadedTagPhoto}
										message={this.props.message ? this.props.message : "تگ ساخته شد"}
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
				tagMessage: tagMessage,
				uploadFile: uploadFile,
				resetTagStatus: resetTagStatus
		}, dispatch);
}

function mapStateToProps(state) {
		return {
				isRequesting: state.tags.isRequesting,
				tags: state.tags.tags,
				hasTags: state.tags.hasTags,
				hasMessage: state.tags.hasMessage,
				message: state.tags.message,
				createdTag: state.tags.createdTag,
				isCreatingTag: state.tags.isCreatingTag,
				uploadedTagPhoto: state.tags.uploadedTagPhoto,
				uploadingTagPhoto: state.tags.uploadingTagPhoto
		};
}
export default connect(mapStateToProps, mapDispatchToProps)(Tags);
module.exports = connect(mapStateToProps, mapDispatchToProps)(Tags);