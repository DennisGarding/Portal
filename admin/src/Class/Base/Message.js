import { v4 } from 'uuid'

export default class Message {
    constructor(title, message, error = '') {
        this.id = v4();
        this.title = title;
        this.message = message;
        this.error = error;
    }
}
