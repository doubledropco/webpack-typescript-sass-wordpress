import React, { useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import { registerBlockType, BlockAttribute, BlockSaveProps, BlockEditProps } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';
import clsx from 'clsx';

type Attributes = {
	uid: string;
	activeTab: string;
}

type AttributesConfig = {
	uid: BlockAttribute<string>;
	activeTab: BlockAttribute<string>;
}

const DEFAULT_ATTRIBUTES: AttributesConfig = {
	activeTab: {
		type: 'string',
		default: '',
	},
	uid: {
		type: 'string',
		default: '',
	},
};

interface TabEditProps extends BlockEditProps<Attributes> {
	clientId: string;
}

const TabEdit: React.FC<TabEditProps> = (props: TabEditProps) => {
	const { className, clientId, attributes, setAttributes } = props;
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

interface TabSaveProps extends BlockSaveProps<Attributes> {
	className?: string;
	clientId?: string;
}

const TabSave: React.FC<TabSaveProps> = (props: TabSaveProps) => {
	const { className, attributes } = props;
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
