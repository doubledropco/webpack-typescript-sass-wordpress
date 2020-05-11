import Flickity from 'flickity';

import 'flickity-fade';


const initHeroBlock = (): void => {
    const elements = document.querySelectorAll('.hero__carousel');
    if (elements) {
        elements.forEach((element: HTMLElement) => {
            new Flickity(element, {
                prevNextButtons: false,
                friction: .15,
                // wrapAround: true,
                // @ts-ignore
                fade: true,
            })
        });
    }
}

export default initHeroBlock;