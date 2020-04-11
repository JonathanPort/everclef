import Framework from './../app/Framework';

const Auth = new Framework('Auth', {
    debug: true,
    modules: ['Notifications'],
});


Auth.init().loadModules();
