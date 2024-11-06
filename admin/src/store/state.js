const state = {
    user: {
        token: sessionStorage.getItem("TOKEN"),
        data: {}
    },
    products: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        current_page: 1,
        total: null,
        limit: null
    },
    categories: {
        loading: false,
        data: []
    }
}

export default state;
