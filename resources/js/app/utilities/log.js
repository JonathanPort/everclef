export default (msg, type = null) => {


    const config = require('./config').default;

    if (! config.debug) return;

    const base = 'padding: 4px 10px 4px 10px;';
    const success = 'background: #457FFD; color: #ffffff';
    const error = 'background: #EB3D52; color: #ffffff';
    const warn = 'background: #EBAA3D; color: #ffffff';
    const info = 'background: #6998FF; color: #ffffff';
    const special = 'padding: 8px 15px 8px 15px; color: #FFFFFF; background-color: #457FFD; font-weight: bold; font-size: 14px; border-radius: 3px;';

    switch (type) {

        case 'success':
            console.log('%c✔︎ ' + msg, base + success);
            break;
        case 'error':
            console.log('%c✕ ' + msg, base + error);
            break;
        case 'warn':
            console.log('%c✕ ' + msg, base + warn);
            break;
        case 'info':
            console.log('%c◎ ' + msg, base + info);
            break;
        case 'special':
            console.log('%c' + msg, special);
            break;
        default:
            console.log('%c◎ ' + msg, base + info);

    }

}