import Axios from 'axios';

Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default Axios;