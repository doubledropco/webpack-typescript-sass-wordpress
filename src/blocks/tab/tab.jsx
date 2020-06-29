import { useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';
import clsx from 'clsx';

const DEFAULT_ATTRIBUTES = {
	activeTab: {
		type: 'string',
		default: '',
	},
	uid: {
		type: 'string',
		default: '',
	},
};

const TabEdit = ({ className, clientId, attributes, setAttributes }) => {
	const { activeTab, uid } = attributes;

	useEffect(() => {
		// only do this if there is no uid already, meaning it is a newly created tab
		if (!uid) {
			setAttributes({ uid: clientId });
		}
	}, []);

	const display = activeTab === uid ? 'block' : 'none';

	return (
		<div className={className} style={{ display }}>
			<InnerBlocks />
		</div>
	);
};

const TabSave = ({ className, attributes }) => {
	const { uid } = attributes;

	return (
		<div className={clsx(className, `tab_${uid}`)} data-tab-id={uid}>
			<InnerBlocks.Content />
		</div>
	);
};

registerBlockType('wordpress-starter/tab', {
	title: __('Tab', 'wordpress-starter'),
	parent: ['wordpress-starter/tabs'],
	category: 'layout',
	attributes: DEFAULT_ATTRIBUTES,
	edit: TabEdit,
	save: TabSave,
});
