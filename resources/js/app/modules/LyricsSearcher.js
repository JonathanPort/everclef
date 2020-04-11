import Module from './Module';
import Axios from './../utilities/axios';

export default class LyricsSearcher extends Module {

    constructor() {

        super();

        this.moduleName = 'LyricsSearcher';

    }


    start() {

        this.inputContainer = document.querySelector('[data-lyrics-search]');

        if (! this.inputContainer) return;

        this.input = this.inputContainer.querySelector('input');
        this.resultsContainer = this.inputContainer.querySelector('.search-input__results');
        this.containerBg = this.inputContainer.querySelector('.search-input__results-bg');
        this.titleInput = document.querySelector('input[name="title"]');
        this.artistInput = document.querySelector('input[name="artist"]');


        if (! this.resultsContainer ||
            ! this.containerBg ||
            ! this.titleInput ||
            ! this.artistInput ||
            ! this.input) return super.logError('One or more missing elems.');

        this.inputKeyupEvent();
        this.inputFocusEvent();
        this.bgClickEvent();

        super.logLoaded();

    }


    createTimer(callback) {

        clearTimeout(this.timer);

        return this.timer = setTimeout(() => callback(), 500);

    }

    inputKeyupEvent() {

        this.input.addEventListener('keyup', () => {

            this.clearResults();

            if (this.input.value.length > 2) {

                this.createTimer(() => {

                    this.showLoadingState();

                    Axios.get('/covers/lyrics-search', {
                        params: {searchQuery: this.input.value}
                    })
                    .then((results) => {

                        this.fillResults(results.data);
                        this.showSearchResults();
                        this.hideLoadingState();

                    })
                    .catch((error) => {
                        console.log(error);
                    });

                });

            } else {
                this.hideSearchResults();
            }

        });

    }

    showSearchResults() {
        this.inputContainer.classList.add('search-input--results-visible');
    }

    hideSearchResults() {
        this.inputContainer.classList.remove('search-input--results-visible');
    }

    showLoadingState() {
        this.inputContainer.classList.add('search-input--loading');
    }

    hideLoadingState() {
        this.inputContainer.classList.remove('search-input--loading');
    }

    fillResults(results) {

        for (let i = 0; i < results.length; i++) {

            this.resultsContainer.append(this.buildResultRow(results[i]));

        }

    }

    clearResults() {
        this.resultsContainer.innerHTML = '';
    }

    buildResultRow(result) {

        let container = document.createElement('div');
        container.classList.add('search-input__result');

        let title = document.createElement('span');
        title.classList.add('search-input__result-title');
        title.innerHTML = result.title;

        let artist = document.createElement('span');
        artist.classList.add('search-input__result-artist');
        artist.innerHTML = result.artist;

        container.append(title);
        container.append(artist);

        this.lyricClickEvent(container, result);

        return container;

    }


    lyricClickEvent(elem, result) {

        elem.addEventListener('click', () => {

            this.showLoadingState();

            Axios.get('/covers/get-lyrics', {
                params: {href: result.href}
            })
            .then((result2) => {

                this.titleInput.value = result.title;
                this.artistInput.value = result.artist;

                Everclef.Modules.LyricsEditor.root.innerHTML = result2.data;

                this.hideSearchResults();
                this.hideLoadingState();
                this.clearResults();

            })
            .catch((error) => {
                console.log(error);
            })

        });

    }


    bgClickEvent() {

        this.containerBg.addEventListener('click', () => {

            this.hideSearchResults();
            this.hideLoadingState();

        });

    }


    inputFocusEvent() {

        this.input.addEventListener('focus', () => {

            if (this.input.value) this.showSearchResults();

        });

    }


}