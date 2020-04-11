import Module from './Module';

export default class ConfirmDialogues extends Module {

    constructor() {

        super();

        this.moduleName = 'ConfirmDialogues';

    }


    start() {

        const confirms = document.querySelectorAll('[data-display-confirm]');

        for (let i = 0; i < confirms.length; i++) {

            confirms[i].addEventListener('click', (e) => {

                if (! confirm(confirms[i].getAttribute('data-display-confirm'))) {
                    e.preventDefault();
                }

            });

        }

        if (confirms.length) return super.logLoaded();

    }

}