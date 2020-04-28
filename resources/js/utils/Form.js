import Errors from './Errors';
import axios from 'axios';

class Form {
    constructor(data) {
        for (let field in data) {
            this[field] = data[field];
        }
        this.originalData = data;
        this.errors = new Errors();
    }

    data() {
        let data = {};
        for (let field in this.originalData) {
            data[field] = this[field];
        }
        return data;
    }

    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }
        this.errors.clear();
    }
}

export default Form;
