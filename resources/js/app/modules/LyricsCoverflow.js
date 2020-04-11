import Module from './Module';
import Swiper from 'swiper';

export default class LyricsCoverflow extends Module {

    constructor() {

        super();

        this.moduleName = 'LyricsCoverflow';

    }

    start() {

        let elem = document.querySelector('.lyrics-coverflow__swiper');

        if (! elem) return;

        this.SwiperInstance = new Swiper(elem, this.config());

        super.logLoaded();

    }

    config() {

        return {
            slideToClickedSlide: true,
            watchSlidesVisibility: true,
            centeredSlidesBounds: true,
            allowTouchMove: false,
            centeredSlides: true,
            mousewheel: true,
            loop: false,
            speed: 200,
            pagination: {
                el: '.swiper-pagination',
                type: 'fraction'
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            // scrollbar: {
            //   el: '.swiper-scrollbar',
            // },
            on: this.eventListeners(),
        };

    }

    eventListeners() {

        const TopScope = this;

        return {

            init: function () {

                TopScope.addIdsToSlides();
                TopScope.addCoverflowClassesToSlides(this);
                TopScope.displayTagsFromSlide(this);

            },

            slideChange: function () {

                TopScope.addCoverflowClassesToSlides(this);
                TopScope.displayTagsFromSlide(this);

            },

        };

    }

    displayTagsFromSlide(Swiper) {

        const activeSlide = Swiper.slides.eq(Swiper.activeIndex)[0];
        const elem = document.querySelector('.lyrics-coverflow__tags');

        let tags = JSON.parse(activeSlide.getAttribute('data-tags'));

        elem.innerHTML = '';

        let tag;
        for (let i = 0; i < tags.length; i++) {

            tag = document.createElement('a');
            tag.href = tags[i].href;
            tag.innerHTML = `#${tags[i].tag}`;

            elem.appendChild(tag);
        }

    }

    addIdsToSlides() {

        const slides = document.querySelectorAll('.swiper-slide');

        for (let i = 0; i < slides.length; i++) {
            slides[i].setAttribute('data-slide-id', i);
        }

    }

    addCoverflowClassesToSlides(Swiper) {

        const slides = document.querySelectorAll('.swiper-slide');
        const slidesArray = [];

        for (let i = 0; i < slides.length; i++) {
            slidesArray.push(slides[i]);
            slides[i].classList.remove('swiper-slide-nth-prev-2');
            slides[i].classList.remove('swiper-slide-nth-next-2');
            slides[i].classList.remove('swiper-slide-prev-out');
            slides[i].classList.remove('swiper-slide-next-out');
        }

        const prevSlides = slidesArray.slice(0, Swiper.activeIndex);
        const nextSlides = slidesArray.slice(Swiper.activeIndex + 1, slides.length);

        if (Swiper.slides.eq(Swiper.activeIndex - 2)[0]) {
            Swiper.slides.eq(Swiper.activeIndex - 2)[0].classList.add('swiper-slide-nth-prev-2');
        }

        if (Swiper.slides.eq(Swiper.activeIndex + 2)[0]) {
            Swiper.slides.eq(Swiper.activeIndex + 2)[0].classList.add('swiper-slide-nth-next-2');
        }

        for (let i = 0; i < prevSlides.length; i++) {
            prevSlides[i].classList.add('swiper-slide-prev-out');
        }

        for (let i = 0; i < nextSlides.length; i++) {
            nextSlides[i].classList.add('swiper-slide-next-out');
        }
    }

}