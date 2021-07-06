export class Classroom {
    constructor(classroom = {}) {
        this.id = classroom.id || null;
        this.title = classroom.title || '';
        this.description = classroom.description || '';
        this.type = classroom.type || 'meeting';
        this.startTime = classroom.startTime || '';
        this.duration = classroom.duration || '';
        this.status = classroom.status || '';
        this.meetingId = classroom.meetingId || '';
        this.meetingPassword = classroom.meetingPassword || '';
        this.courseId = classroom.courseId || '';
        this.moduleId = classroom.moduleId || '';
        this.topicId = classroom.topicId || '';
        this.instructorId = classroom.instructorId || '';
        this.course = classroom.course || null;
        this.module = classroom.module || null;
        this.topic = classroom.topic || null;
        this.remarks = classroom.remarks || '';
    }
}
