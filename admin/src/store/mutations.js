export function setUser(state, user){
    state.user.data = user;
}

export function setToken(state, token){
    state.user.token = token;
    if(token){
        //sessionStorage: This is a Web Storage API that allows you to store data in a web browser. Data stored in sessionStorage is available for the duration of the page session (as long as the tab or window is open). Once the page is closed, the data is cleared.
        //sessionStorage: Data is tied to the specific browser tab.
        sessionStorage.setItem('TOKEN', token)
    }else{
        sessionStorage.removeItem('TOKEN')
    }
}

export function setProducts(state, [loading, response = null]){
    if(response){
        state.products = {
            data: response.data,
            links: response.meta.links,
            total: response.meta.total,
            limit: response.meta.per_page,
            from: response.meta.from,
            to: response.meta.to,
            current_page: response.meta.current_page
        }
    }

    state.products.loading = loading
}

export function setCategories(state, [loading, response=null]){
    if(response){
        state.categories = {
            ...state.categories,
            data: response.data
        }
    }
    state.categories.loading = loading;
}


