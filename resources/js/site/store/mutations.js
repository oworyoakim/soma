import globalMutations from "../../shared/store/mutations";
export default {
    ...globalMutations,
    SET_LEARNING_PATHS(state, payload){
      state.learningPaths = payload || [];
    },
}
