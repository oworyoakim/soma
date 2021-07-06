import globalMutations from "../../shared/store/mutations";

export default {
    ...globalMutations,
    SET_LOADER(state, payload) {
        state.isLoading = payload;
    },
    SET_PRELOADER(state, payload) {
        state.preLoader = payload;
    },
    SET_DASHBOARD_STATISTICS(state, payload) {
        state.dashboardStatistics = payload;
    },
}
