export class Question {
    constructor() {
        this.id = null;
        this.title = '';
        this.description = '';
        this.type = '';
        this.weight = 1;
        this.active = true;
        this.shuffleAnswers = true;
        this.topicId = '';
        this.topic = null;
        this.moduleId = '';
        this.module = null;
        this.answers = [];
    }
}
