export class Course {
    constructor(course = {}) {
        this.id = course.id || null;
        this.code = course.code || '';
        this.title = course.title || '';
        this.slug = course.slug || '';
        this.description = course.description || '';
        this.weight = course.weight || null;
        this.duration = course.duration || null;
        this.thumbnail = course.thumbnail || '';
        this.levelId = course.levelId || '';
        this.level = course.level || null;
        this.numberOfEnrollments = course.numberOfEnrollments || null;
        this.numberOfModules = course.numberOfModules || null;
        this.canBeEnrolledFor = course.canBeEnrolledFor || false;
        this.canTakeExam = course.canTakeExam || false;
        this.modules = course.modules || [];
        this.programIds = course.programIds || [];
    }
}
