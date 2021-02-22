export default class Exam {
    constructor() {
        this.id = null;
        this.code = '';
        this.numberOfQuestions = null;
        this.maximumAttempts = null;
        this.passMark = null;
        this.duration = null;
        this.instructions = '';
        this.intakeId = null;
        this.courseId = null;
        this.programId = null;
        this.levelId = null;
        this.course = null;
        this.intake = null;
        this.modules = [];
        this.active = false;
    }
}
