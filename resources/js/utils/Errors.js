class Errors {
    constructor() {
        this.errors = {};
    }

    /**
     *
     * @param errors {Object}
     */
    record(errors){
        for (let field in errors) {
            this.errors[field] = errors[field];
        }
    }

    /**
     *
     * @param field {string}
     * @returns {null|string}
     */
    get(field) {
        if (this.errors.hasOwnProperty(field)) {
            return this.errors[field][0];
        }
        return null;
    }

    clear(field = null) {
        if (field){
            delete this.errors[field];
            return;
        }
        this.errors = {};
    }

    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    any() {
        return Object.keys(this.errors).length > 0;
    }
}

export default Errors;