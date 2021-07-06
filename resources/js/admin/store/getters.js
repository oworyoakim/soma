import globalGetters from "../../shared/store/getters";
export default {
    ...globalGetters,
    LOADING(state) {
        return state.isLoading;
    },
    PRE_LOADER(state) {
        return state.preLoader;
    },
    DASHBOARD_STATISTICS(state) {
        return state.dashboardStatistics;
    },
}
