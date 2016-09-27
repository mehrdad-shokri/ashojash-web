import {enzyme} from '../test_helper';
import {expect} from 'chai';
import React from 'react';
import CommentBox from '../../src/components/comment_box';
describe('CommentBox', () => {
		let wrapper;
		beforeEach(() => {
				wrapper = enzyme(CommentBox);
		});


		describe('entering some text', () => {
				beforeEach(() => {
						wrapper.find('textarea').simulate('change', {target: {value: 'new comment'}});
				});

				it('shows that text in the textarea', () => {
						expect(wrapper.find('h4').text()).to.be.equal('Add a comment');
						expect(wrapper.find('textarea').props().value).to.be.equal('new comment');
				});

		});
});
