import log from './utilities/log';

export default class Framework {


    constructor(name, config = null)
    {
        this.name = name;
        this.config = this._setupConfig(config);
    }

    init() {

        log(`🎧 ${this.name} - © Freeman Design Ltd`, 'special');

        log('Initialising...');

        //

        log('Initialised.', 'success');

        return this;
    }

    loadModules() {

        log('Loading modules...');

        let Module;
        const modules = this.config.modules;

        for (let i = 0; i < modules.length; i++) {

            Module = require(`./modules/${modules[i]}`);

            new Module.default().start();

        }

        log('Modules Loaded.', 'success');

        return this;

    }

    startEventListeners() {

        log('Starting event listeners...');

        //

        log('Event listeners started.', 'success');

        return this;
    }


    /**
     * @var config : Object
     */
    _setupConfig(config)
    {

        if (! window[this.name]) window[this.name] = {};

        if (typeof config !== 'object') {
            config = window[this.name].config ? window[this.name].config : {};
        }

        if (! config.modules || typeof config.modules !== 'object') {
            config.modules = [];
        }

        return window[this.name].config = this.config = config;

    }

}