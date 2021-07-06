export class CourseModule {
    constructor(module = {}) {
        this.id = module.id || null;
        this.courseId = module.courseId || null;
        this.title = module.title || null;
        this.description = module.description || null;
        this.duration = module.duration || null;
        this.createdBy = module.createdBy || null;
        this.topics = module.topics || [];
        this.numTopics = module.numTopics || 0;
        this.questions = module.questions || [];
        this.numQuestions = module.numQuestions || 0;
        this.maxNumQuestions = module.maxNumQuestions || 0;
    }
}
