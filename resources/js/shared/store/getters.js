export default {
    FORM_SELECTIONS_OPTIONS(state) {
        return state.formSelectionOptions;
    },
    EDITOR_CONFIG(state) {
        return state.editorConfig;
    },
    singleDatePickerConfig(state){
        return state.singleDatePickerConfig;
    },
    IS_ACTIVE_PATH(state) {
        return (paths = []) => {
            //return paths.includes(location.pathname);
            return paths.some((path) => location.pathname.includes(path));
        }
    },
}
