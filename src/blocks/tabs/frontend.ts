import $ from 'jquery';

const setActiveTab = (block: HTMLElement, tabId: string): void => {
    block.querySelectorAll('.wp-block-wordpress-starter-tab').forEach(content => {
        if (tabId === content.getAttribute('data-tab-id')) {
            content.classList.add('wp-block-wordpress-starter-tab--active');
        } else {
            content.classList.remove('wp-block-wordpress-starter-tab--active');
        }
    });
    
    block.querySelectorAll('.wp-block-wordpress-starter-tabs__tab').forEach(tab => {
        if (tabId === tab.getAttribute('data-tab-id')) {
            tab.classList.add('wp-block-wordpress-starter-tabs__tab--active');
        } else {
            tab.classList.remove('wp-block-wordpress-starter-tabs__tab--active');
        }
    });
}

$(document).ready(function () {
    document.querySelectorAll('.wp-block-wordpress-starter-tabs').forEach((tabBlock: HTMLElement) => {
        tabBlock.querySelectorAll('.wp-block-wordpress-starter-tabs__tab')
            .forEach((header: HTMLElement, index: number) => {
                if (index === 0) {
                    const tabId = header.getAttribute('data-tab-id');
                    setActiveTab(tabBlock, tabId);
                }


                header.addEventListener('click', () => {
                    const clickedTabId = header.getAttribute('data-tab-id');
                    setActiveTab(tabBlock, clickedTabId);
                });
            });

    });
});
