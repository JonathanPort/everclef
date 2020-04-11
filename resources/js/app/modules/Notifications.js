import Module from './Module';
import Noty from 'noty';


export default class Notifications extends Module {


    constructor() {

        super();

        this.moduleName = 'Notifications';

    }

    start() {

        const elems = document.querySelectorAll('.notification');

        for (let i = 0; i < elems.length; i++) {

            new Noty({
                text: elems[i].getAttribute('data-notification-message'),
                type: elems[i].getAttribute('data-notification-type') || 'info',
                progressBar: true,
                theme: 'nest',
                timeout: 5000,
                layout: 'topCenter',
                animation: {
                    open: 'animated slideInDown', // Animate.css class names
                    close: 'animated slideOutUp' // Animate.css class names
                }
            }).show();

        }

        if (elems.length) return super.logLoaded();

    }

}