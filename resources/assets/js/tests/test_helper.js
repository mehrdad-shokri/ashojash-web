import jsdom from 'jsdom';
import {expect} from 'chai';
import React from 'react';
import {Provider} from 'react-redux';
import {createStore} from 'redux';
import reducers from '../src/reducers';
import {mount} from 'enzyme';
// Set up testing environment to run like a browser in the command line
global.document = jsdom.jsdom('<!doctype html><html><body></body></html>');
global.window = global.document.defaultView;

function enzyme(ComponentClass, props, state) {
		const componentInstance = mount(
				<Provider store={createStore(reducers, state)}>
						<ComponentClass {...props} />
				</Provider>
		);
		return componentInstance;
}
export {expect, enzyme};
