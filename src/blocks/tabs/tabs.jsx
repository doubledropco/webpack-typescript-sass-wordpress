import { useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import { registerBlockType, createBlock } from '@wordpress/blocks';
import { InnerBlocks, RichText } from '@wordpress/block-editor';
import { withDispatch } from '@wordpress/data';
import { compose } from '@wordpress/compose';
import { IconButton, ButtonGroup, Button } from '@wordpress/components';
import clsx from 'clsx';

const ALLOWED_BLOCKS = ['wordpress-starter/tab'];
const DEFAULT_ATTRIBUTES = {
	tabs: {
		type: 'array',
		default: []
	},
	tabActive: {
		type: 'string',
		default: '',
	},
};

const arrayMove = (arr, oldIndex, newIndex) => {
    if (newIndex >= arr.length) {
        let k = newIndex - arr.length + 1;
        while (k--) {
            arr.push(undefined);
        }
    }
    arr.splice(newIndex, 0, arr.splice(oldIndex, 1)[0]);
};


const TabHeader = ({
	children,
	className,
	active,
	first,
	last,
	moveLeft,
	moveRight,
	remove
}) => {
	let tabClass = `${className}__tab`;
	if (active) {
		tabClass += ` ${className}__tab--active`;
	}

	return (
		<div
			className={tabClass}
		>
			{active && (
				<div className={`${className}__controls`}>
					<ButtonGroup>
						<Button isSmall disabled={first} onClick={moveLeft}><i class="fas fa-chevron-left"></i></Button>
						<Button isSmall onClick={remove}><i class="fas fa-times"></i></Button>
						<Button isSmall disabled={last} onClick={moveRight}><i class="fas fa-chevron-right"></i></Button>
					</ButtonGroup>
				</div>
			)}
			{children}
		</div>
	);
};

const TabsEdit = ({
	clientId,
	className,
	attributes,
	setAttributes,
	setActiveTab,
	insertBlock,
	moveBlockToPosition,
	getBlock,
	removeBlock,
}) => {
	const { tabs, activeTab } = attributes;

	useEffect(() => {
		if (tabs.length && !activeTab) {
			setActiveTab(tabs[0].uid);
		}
	}, []);

	return (
		<div className={className}>
			<div className={`${className}__tabs`}>
				{tabs.map(({ title, uid }, i) => {
					return (
						<TabHeader
							className={className}
							key={uid}
							active={uid === activeTab}
							first={i === 0}
							last={i + 1 === tabs.length}
							moveLeft={() => {
								const newTabs = [...tabs];
								const block = getBlock(clientId);
								const childBlock = block.innerBlocks.find(b => b.attributes.uid === uid);
								arrayMove(newTabs, i, i - 1);
								setAttributes({ tabs: newTabs });
								moveBlockToPosition(childBlock.clientId, block.clientId, block.clientId, i - 1);

							}}
							moveRight={() => {
								const newTabs = [...tabs];
								const block = getBlock(clientId);
								const childBlock = block.innerBlocks.find(b => b.attributes.uid === uid);
								arrayMove(newTabs, i, i + 1);
								setAttributes({ tabs: newTabs });
								moveBlockToPosition(childBlock.clientId, block.clientId, block.clientId, i - 1);
							}}
							remove={() => {
								const newTabs = tabs.filter(t => t.uid !== uid);
								const block = getBlock(clientId);
								const childBlock = block.innerBlocks.find(b => b.attributes.uid === uid);
								setAttributes({ tabs: newTabs });
								removeBlock(childBlock.clientId);
							}}
						>
							<div
								onClick={() => setActiveTab(uid)}
								onKeyDown={() => setActiveTab(uid)}
								role="tab"
								tabIndex="0"
							>
								<RichText
									tagName="div"
									value={title}
									onChange={(value) => {
										const newTabs = [...tabs];
										newTabs[i].title = value;
										setAttributes({ tabs: newTabs });
									}}
								/>
							</div>
						</TabHeader>
					);
				})}
				<IconButton
					icon="plus"
					label="Add Tab"
					onClick={() => {
						const position = tabs.length;
						const tab = createBlock(
							'wordpress-starter/tab'
						);
						insertBlock(tab, position, clientId);
						setAttributes({
							tabs: [
								...tabs,
								{
									uid: tab.clientId,
									title: 'New Tab',
								},
							],
						});
						setActiveTab(tab.clientId);
					}}
				/>
			</div>
			<InnerBlocks
				allowedBlocks={ALLOWED_BLOCKS}
				renderAppender={false}
			/>
		</div>
	);
};

const TabsSave = ({ attributes }) => {
	const className = 'wp-block-wordpress-starter-tabs';
	const { tabs } = attributes;

	return (
		<div className={className}>
			<div className={`${className}__tabs-wrapper`}>
				<div className={`${className}__tabs`}>
					{tabs.map(({ title, uid }, i) => {
						return (
							<div
								key={uid}
								data-tab-id={uid}
								className={clsx(
									`${className}__tab`,
									i === 0 && `${className}__tab--active`
								)}
							>
								{title}
							</div>
						);
					})}
				</div>
			</div>

			<div className={`${className}__tabs-content`}>
				<InnerBlocks.Content />
			</div>
		</div>
	);
};

registerBlockType('wordpress-starter/tabs', {
	title: __('Tabs', 'wordpress-starter'),
	category: 'layout',
	attributes: DEFAULT_ATTRIBUTES,
	edit: compose(
		withDispatch((dispatch, ownProps, { select }) => {
			const { getBlock } = select('core/block-editor');
			const { updateBlockAttributes, insertBlock, removeBlock, moveBlockToPosition } = dispatch(
				'core/block-editor'
			);
			const block = getBlock(ownProps.clientId);

			return {
				getBlock,
				moveBlockToPosition,
				insertBlock,
				removeBlock,
				setActiveTab(activeTab) {
					updateBlockAttributes(ownProps.clientId, { activeTab });
					block.innerBlocks.forEach((innerBlock) => {
						updateBlockAttributes(innerBlock.clientId, {
							activeTab,
						});
					});
				},
			};
		})
	)(TabsEdit),
	save: TabsSave,
});
