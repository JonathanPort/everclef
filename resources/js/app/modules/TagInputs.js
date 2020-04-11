import Module from './Module';
import Tagify from '@yaireo/tagify'

export default class TagInputs extends Module {

    constructor() {

        super();

        this.moduleName = 'TagInputs';

    }

    start() {

        const inputs = document.querySelectorAll('[data-tag-input]');

        for (let i = 0; i < inputs.length; i++) {

            let tagify = new Tagify(inputs[i], {
                whitelist : JSON.parse(inputs[i].getAttribute('data-tag-input')),
                dropdown : {
                    // classname : ,
                    enabled   : 0,         // show the dropdown immediately on focus
                    maxItems  : 5,
                    position  : "text",    // place the dropdown near the typed text
                    closeOnSelect : true, // keep the dropdown open after selecting a suggestion
                }
            });

            let existing = inputs[i].getAttribute('data-tag-input-existing');

            if (existing) tagify.addTags(JSON.parse(existing))

        }

        if (inputs.length) return super.logLoaded();

    }

}
