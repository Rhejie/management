
const state = {
    current: 'Dashboard',
    navs: [
        {
            label: 'Dashboard',
            icon: 'flaticon-381-networking',
            isActive: true,
            url: '/home'
        },
        {
            label: 'User Account',
            icon: 'flaticon-381-user-9',
            isActive: false,
            contents: [
                {
                    text: 'Register User',
                    link: '/register'
                },
                {
                    text: 'User List',
                    link: '/user-list'
                },
            ],
        },
        {
            label: 'Inventory',
            isActive: false,
            icon: 'flaticon-381-notepad',
            contents: [
                {
                    text: 'Add Asset',
                    link: '/add-asset'
                },
                {
                    text: 'Asset List',
                    link: '/asset-list'
                },
                // {
                //     text: 'Asset Inquiry',
                //     link: '/asset-inquiry'
                // },
            ],
        },
        {
            label: 'Asset Users',
            isActive: false,
            icon: 'bi bi-person-workspace',
            contents: [
                {
                    text: 'Add Asset User',
                    link: '/asset-user-add'
                },
                {
                    text: 'Asset User List',
                    link: '/proponent-list'
                },
            ],
        },
        {
            label: 'Transactions',
            isActive: false,
            icon: 'flaticon-381-network-3',
            contents: [
                {
                    text: 'Assign New',
                    link: '/transactions/assign'
                },
                {
                    text: 'Transfer',
                    link: '/transactions/transfer'
                },
                {
                    text: 'Disposal',
                    link: '/transactions/disposal'
                },
            ],
        },
        {
            label: 'Maintenance',
            isActive: false,
            icon: 'flaticon-381-settings-3',
            contents: [
                {
                    text: 'Roles and System Access',
                    link: '/system-access'
                },
                {
                    text: 'Master List',
                    link: '/master-list'
                },
            ],
        },
    ],
};

const getters = {
    navs: (state) => state.navs,
    current: (state) => state.current,
};

const actions = {
    urlPush({ commit }, nav) {
        commit('CHANGE_STATUSES');
        commit('CHANGE_STATUS', nav);
    },
};

const mutations = {
    CHANGE_STATUSES: (state) => {
        state.navs.forEach(nav => {
            nav.isActive = false
        });
    },
    CHANGE_STATUS: (state, nav) => {
        let navigator = state.navs.find(function (item) {
            return item.label == nav.label;
        });
        navigator.isActive = true;
        state.current = navigator.label;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};