import log from './../utilities/log';

export default class Module {

    constructor() {}

    expose(data) {

        if (! Everclef.Modules) Everclef.Modules = {};

        Everclef.Modules[this.moduleName] = data;

    }

    logLoaded() {

        return log(`${this.moduleName} module loaded.`, 'success');

    }

    logNotLoaded() {

        return log(`${this.moduleName} module not loaded.`, 'warn');

    }

    logError(error) {

        return log(`${this.moduleName}: ${error}`, 'error');

    }


}