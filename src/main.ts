import './scripts/modernizr';
import 'intersection-observer';

import $ from 'jquery';
import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock';
import ScrollMagic from 'scrollmagic';
import Lazyload from 'vanilla-lazyload';

import initHeroBlock from '@blocks/hero';
declare global {
    interface Window { 
        gmak: string; // gmak - Google Maps API Key
        initGoogleMaps: () => void; 
    }
}

const supportPageOffset = window.pageXOffset !== undefined;
const isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");

const getScrollPosition = (): { scrollX: number; scrollY: number } => {
    const x = supportPageOffset ? window.pageXOffset : isCSS1Compat ? document.documentElement.scrollLeft : document.body.scrollLeft;
    const y = supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;
    return { scrollX: x, scrollY: y };
}

const initLazyLoad = (): void => {
    new Lazyload({
        // eslint-disable-next-line
        elements_selector: '[data-bg], [data-src]',
        // eslint-disable-next-line
        callback_loaded: (el : HTMLElement) => {
            if (el.parentElement.classList.contains('hero')) {
                el.parentElement.classList.add('hero--loaded');
            }
        },
    })
}


const initParallax = (): void => {
    const maxTranslation = 300;
    const items = document.querySelectorAll('.parallax');
    const adjust = (item: HTMLElement): void => {
        const { scrollY } = getScrollPosition();
        let translation = Math.floor((scrollY - item.parentElement.offsetTop) / 4);

        if (translation > maxTranslation) {
            translation = maxTranslation;
        }

        if (translation < -maxTranslation) {
            translation = -maxTranslation;
        }

        item.style.transform = `translate3d(0, ${translation}px, 0)`;
    }

    if (items && items.length) {
        items.forEach((item: HTMLElement) => adjust(item));
    }

    document.addEventListener('scroll', () => {
        if (items && items.length) {
            items.forEach((item: HTMLElement) => adjust(item))
        }
    }, window.Modernizr.passiveeventlisteners ? {passive: true} : false)
}

const initDynamicHeader = (): void => {
    const header = document.getElementById('header');
    const setHeaderScrolled = (): void => {
        const { scrollY } = getScrollPosition();
        if (scrollY > 50) {
            header.classList.add('header--scrolled');
        } else {
            header.classList.remove('header--scrolled');
        }
    }

    document.addEventListener('scroll', () => {
        setHeaderScrolled();
    }, window.Modernizr.passiveeventlisteners ? {passive: true} : false);
}

const initGoogleMaps = (): void => {
    console.log('Initialize Google Maps...');
}

let mobileMenuOpen = false;
const initMobileMenuToggle = (): void => {
    // init mobile menu toggle
    //
    const header = document.getElementById('header');
    const toggle = document.getElementById('mobile-nav-toggle');
    const navigation = document.getElementById('header__mobile-nav');

    toggle.addEventListener('click', () => {
        mobileMenuOpen = !mobileMenuOpen;

        if (mobileMenuOpen) {
            // open the menu
            enableBodyScroll(navigation);
            toggle.classList.remove('is-active');
            header.classList.remove('header--mobile-nav-open');
            navigation.classList.remove('header__mobile-nav--open');
        } else {
            // close the menu
            disableBodyScroll(navigation);
            toggle.classList.add('is-active');
            header.classList.add('header--mobile-nav-open');
            navigation.classList.add('header__mobile-nav--open');
        }
    });
}


const initScrollMagic = (): void => {
    const controller = new ScrollMagic.Controller();
    const main = document.getElementById('site-content');
    const selectors = [
        '.sm-element',
    ]
    const elements = main.querySelectorAll(selectors.join(', '));

    if (elements) {
        elements.forEach((element: HTMLElement) => {
            new ScrollMagic.Scene({
                triggerElement: element,
                reverse: false,
                triggerHook: .9,
            })
                .setClassToggle(element, 'sm-visible')
                .addTo(controller);
        })
    }
}

$(document).ready(function() {
    [
        initHeroBlock,
        initLazyLoad,
        initParallax,
        initMobileMenuToggle,
        initScrollMagic,
        initDynamicHeader,
    ].forEach(fn => {
        try {
            fn();
        } catch (e) {
            console.error(e);
        }
    })


    if (window.gmak) {
        window.initGoogleMaps = initGoogleMaps;
        const s = document.createElement('script');
        s.async = true;
        s.defer = true;
        s.src = `https://maps.googleapis.com/maps/api/js?key=${window.gmak}&callback=initGoogleMaps`;
        document.body.appendChild(s);
    }
});
