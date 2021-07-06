import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import authModule from "../../shared/store/modules/auth";
import globalState from "../../shared/store/state";
import getters from "./getters";
import mutations from "./mutations";
import actions from "./actions";

const state = {
    ...globalState,
    learningPaths: [],
};

const modules = {
    authModule,
};

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    modules,
});
