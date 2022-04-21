import {
    http
} from './config'

export default {

    create: (user) => {
        return http.post('user', user);
    },

    update: (id, user) => {
        return http.put('user/' + id, user);
    },

    get: () => {
        return http.get('user')
    },

    delete: (id) => {
        return http.delete('user/' + id)
    }
}
