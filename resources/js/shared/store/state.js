export default {
    formSelectionOptions: {
        learningPaths: [],
        courses: [],
        levels: [],
        users: [],
        students: [],
        roles: [],
        instructors: [],
        modules: [],
    },
    editorConfig: {
        height: 360,
        media_live_embeds: true,
        menubar: "insert edit format",
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks fullscreen',
            'insertdatetime media table paste hr code wordcount',
            'toc'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image video code|toc'
    },
    dateTimeRangePickerConfig: {
        showDropdowns: true,
        singleDatePicker: true,
        timePickerIncrement: 5,
        timePicker: true,
        minDate: new Date(),
        opens: "center",
        drops: "up",
        locale: {
            format: 'YYYY-MM-DD HH:mm'
        }
    },
    singleDatePickerConfig: {
        showDropdowns: true,
        singleDatePicker: true,
        maxDate: new Date(),
        opens: "center",
        drops: "up",
        locale: {
            format: 'YYYY-MM-DD'
        }
    },
}
