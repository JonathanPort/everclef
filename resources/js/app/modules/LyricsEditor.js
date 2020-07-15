import Module from './Module';
import Quill from 'quill';

export default class LyricsEditor extends Module {

    constructor() {

        super();

        this.moduleName = 'LyricsEditor';

    }


    start() {

        this.elem = document.querySelector('[data-quill-editor]');
        this.form = document.querySelector('[data-quill-form]');
        this.hiddenInput = document.querySelector('[data-quill-hidden-input]');

        if (! this.elem) return;

        if (! this.form) super.logError('Missing form element.');
        if (! this.hiddenInput) super.logError('Missing hiddenInput element.');

        if (! this.form || ! this.hiddenInput) return;

        const options = {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'blockquote'],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{'align': ['', 'right', 'center', 'justify']}],
                ],
                history: {
                    delay: 2000,
                    maxStack: 500,
                }
            },
            placeholder: this.elem.getAttribute('placeholder'),
            theme: 'snow'
        };

        this.Editor = new Quill(this.elem, options);

        this.onSubmitEvent();

        this.addEditorFunctions();

        super.expose(this.Editor);

        super.logLoaded();

    }


    onSubmitEvent() {

        this.form.addEventListener('submit', (e) => {

            this.hiddenInput.value = this.Editor.root.innerHTML;

        });

    }


    addEditorFunctions() {

        this.Editor.addLyrics = (lyrics) => {

            this.Editor.root.innerHTML = lyrics;

        };

    }

}
