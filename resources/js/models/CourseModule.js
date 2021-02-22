export default class CourseModule {
    constructor() {
        this.id = null;
        this.courseId = null;
        this.title = null;
        this.description = null;
        this.duration = null;
        this.createdBy = null;
        this.topics = [];
        this.numTopics = 0;
        this.questions = [];
        this.numQuestions = 0;
        this.maxNumQuestions = 0;
    }
}
