import React, {Component} from 'react';
import styles from '../../../../sass/components/auth/loginButton.scss'
const Ink = require('react-ink');
const classnames = require('classnames/bind');
const cx = classnames.bind(styles);
const LoginButton = (props)=> {
		const {isProcessing, isSuccess, isError, handleClick, action} = props;
		return (
				<button action={action} className={cx('loginBtn',
						{
								"isProcessing": isProcessing,
						},
						{'isSuccess': isSuccess && !isProcessing},
						{'isError': isError && !isProcessing},
						{'fa': isSuccess && !isProcessing},
						{'fa  fa-check': isSuccess && !isProcessing},
						{'fa fa-times': isError && !isProcessing}
				)}
								onClick={handleClick}
								disabled={isSuccess | isProcessing}
				>
						{(!(isProcessing || isSuccess || isError) ? 'ورود' : '')} <Ink duration={200} radius={400}/>
				</button>
		);
}


module.exports = LoginButton
