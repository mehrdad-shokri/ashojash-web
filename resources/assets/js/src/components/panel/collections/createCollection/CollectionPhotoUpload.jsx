import React, {Component} from 'react';
import styles from '../../../../../../sass/components/panel/collections/CreateCollection.scss'
const classNames = require('classnames/bind');
const cx = classNames.bind(styles);
const DropZone = require('react-dropzone');

export default class CollectionPhotoUpload extends Component {
    static get maxSize() {
        return 5000000;
    }

    constructor(props) {
        super(props);
        this.state = {files: []};
        this.onDrop = this.onDrop.bind(this);
    }

    onDrop(files) {
        this.setState({files});
        this.props.onDrop(files[0]);
        this.props.input.onChange(files[0])
    };

    render() {
        const files = this.props.input.value;
        return (
            <div>
                <DropZone
                    className={cx('dropzone')}
                    onDrop={this.onDrop}
                    multiple={false}
                    maxSize={CollectionPhotoUpload.maxSize}
                    name={this.props.name}
                    accept="image/*">
                    <img className={cx('dropzoneContainer')}
                         src={require('../../../../../../statics/img/components/panel/collections/container.png')}
                         alt=""/>
                </DropZone>
                {this.state.files.length > 0 ?
                    <div className={cx('photoContainer')}>
                        <img className={cx('photo')} src={this.state.files[0].preview} alt=""/>
                    </div> :
                    <img className={cx('preview')}
                         src={require('../../../../../../statics/img/components/panel/collections/preview.png')}
                         alt=""/>
                }
                {this.props.meta.touched &&
                this.props.meta.error &&
                <span className="error">{this.props.meta.error}</span>}
                {files && Array.isArray(files) && (
                    <ul>
                        { files.map((file, i) => <li key={i}>{file.name}</li>) }
                    </ul>
                )}
            </div>
        )
    }
}