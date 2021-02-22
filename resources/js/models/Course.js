export default class Course {
    constructor() {
        this.id = null;
        this.code = '';
        this.title = '';
        this.slug = '';
        this.description = '';
        this.weight = null;
        this.duration = null;
        this.thumbnail = '';
        this.levelId = '';
        this.level = null;
        this.numEnrolled = null;
        this.numModules = null;
        this.canBeEnrolledFor = false;
        this.canTakeExam = false;
        this.modules = [];
        this.programIds = [];
    }
}
