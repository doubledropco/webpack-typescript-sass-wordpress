import React, { useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import { registerBlockType, createBlock, BlockAttribute, BlockInstance, BlockEditProps, BlockSaveProps } from '@wordpress/blocks';
import { InnerBlocks, RichText } from '@wordpress/block-editor';
import { withDispatch } from '@wordpress/data';
import { compose } from '@wordpress/compose';
import { IconButton, ButtonGroup, Button } from '@wordpress/components';
import clsx from 'clsx';

type Tab = {
	title: string;
	uid: string;
}

type Attributes = {
	tabs: Tab[];
	activeTab: string;
}

type AttributesConfig = {
	tabs: BlockAttribute<Tab>;
	activeTab: BlockAttribute<string>;
}

const ALLOWED_BLOCKS = ['wordpress-starter/tab'];
const DEFAULT_ATTRIBUTES: AttributesConfig = {
	tabs: {
		type: 'array',
		default: []
	},
	activeTab: {
		type: 'string',
		default: '',
	},
};

const moveTab = (arr: Tab[], oldIndex: number, newIndex: number): void => {
    if (newIndex >= arr.length) {
        let k = newIndex - arr.length + 1;
        while (k--) {
            arr.push(undefined);
        }
    }
    arr.splice(newIndex, 0, arr.splice(oldIndex, 1)[0]);
};

type TabHeaderProps = {
	children?: React.ReactElement;
	className?: string;
	active: boolean;
	first: boolean;
	last: boolean;
	moveLeft: () => void;
	moveRight: () => void;
	remove: () => void;
}

const TabHeader: React.FC<TabHeaderProps> = (props: TabHeaderProps) => {
	const {
		children,
		className,
		active,
		first,
		last,
		moveLeft,
		moveRight,
		remove
	} = props;

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
						<Button isSmall disabled={first} onClick={moveLeft}><i className="fas fa-chevron-left"></i></Button>
						<Button isSmall onClick={remove}><i className="fas fa-times"></i></Button>
						<Button isSmall disabled={last} onClick={moveRight}><i className="fas fa-chevron-right"></i></Button>
					</ButtonGroup>
				</div>
			)}
			{children}
		</div>
	);
};

interface TabsEditProps extends BlockEditProps<Attributes> {
	clientId?: string;
	attributes: Attributes;
	setActiveTab: (uid: string) => void;
	removeBlock: (clientId: string, selectPrevious?: boolean) => void;
	insertBlock: (
		block: BlockInstance,
		index?: number,
		rootClientId?: string,
		updateSelection?: boolean
	) => void;
	moveBlockToPosition: (
		clientId: string | undefined,
		fromRootClientId: string | undefined,
		toRootClientId: string | undefined,
		index: number
	) => IterableIterator<void>;
	getBlock: (clientId: string) => BlockInstance | null;
}

const TabsEdit: React.FC<TabsEditProps> = (props: TabsEditProps) => {
	const {
		clientId,
		className,
		attributes,
		setAttributes,
		setActiveTab,
		insertBlock,
		moveBlockToPosition,
		getBlock,
		removeBlock,
	} = props;
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
							moveLeft={(): void => {
								const newTabs = [...tabs];
								const block = getBlock(clientId);
								const childBlock = block.innerBlocks.find(b => b.attributes.uid === uid);
								moveTab(newTabs, i, i - 1);
								setAttributes({ tabs: newTabs });
								moveBlockToPosition(childBlock.clientId, block.clientId, block.clientId, i - 1);

							}}
							moveRight={(): void => {
								const newTabs = [...tabs];
								const block = getBlock(clientId);
								const childBlock = block.innerBlocks.find(b => b.attributes.uid === uid);
								moveTab(newTabs, i, i + 1);
								setAttributes({ tabs: newTabs });
								moveBlockToPosition(childBlock.clientId, block.clientId, block.clientId, i - 1);
							}}
							remove={(): void => {
								const newTabs = tabs.filter(t => t.uid !== uid);
								const block = getBlock(clientId);
								const childBlock = block.innerBlocks.find(b => b.attributes.uid === uid);
								setAttributes({ tabs: newTabs });
								removeBlock(childBlock.clientId);
							}}
						>
							<div
								onClick={(): void => setActiveTab(uid)}
								onKeyDown={(): void => setActiveTab(uid)}
								role="tab"
								tabIndex={0}
							>
								<RichText
									tagName="div"
									value={title}
									onChange={(value): void => {
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
					onClick={(): void => {
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
				renderAppender={() => null}
			/>
		</div>
	);
};

type TabsSaveProps = BlockSaveProps<Attributes>;

const TabsSave: React.FC<TabsSaveProps> = (props: TabsSaveProps) => {
	const className = 'wp-block-wordpress-starter-tabs';
	const { attributes } = props;
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
			// @ts-ignore
			const block = getBlock(ownProps.clientId);

			return {
				getBlock,
				moveBlockToPosition,
				insertBlock,
				removeBlock,
				setActiveTab(activeTab: string): void {
					// @ts-ignore
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
