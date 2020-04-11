export default (uri) => {

    if (! uri.startsWith('/')) uri = `/${uri}`;

    return window.location.origin + uri;

};