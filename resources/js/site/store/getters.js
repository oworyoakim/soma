import globalGetters from "../../shared/store/getters";
export default {
    ...globalGetters,
    LEARNING_PATHS(state){
        return state.learningPaths;
    },
}
