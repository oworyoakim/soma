export class Topic {
    constructor(topic = {}) {
        this.id = topic.id || null;
        this.title = topic.title || '';
        this.description = topic.description || '';
        this.body = topic.body || '';
        this.active = topic.active || null;
        this.courseId = topic.courseId || '';
        this.moduleId = topic.moduleId || '';
        this.module = topic.module || null;
        this.classroom = topic.classroom || null;
    }
}
