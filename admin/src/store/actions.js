import axiosClient from '../axios';

export function login({commit}, data){
    return axiosClient.post('/login', data)
        .then(({data})=>{
            commit('setUser', data.user);
            commit('setToken', data.token);

            return data;
        })
}


export function logout({commit}, data){
    return axiosClient.post('/logout')
        .then(response => {
            commit('setToken', null)
            return response
        })
}

export function getCurrentUser({commit}){
    return axiosClient.get('/user')
        .then(({data})=>{
            commit('setUser', data)
        })
}

export function getProducts({commit}, {url=null, search='', perPage=10, sort_field, sort_direction} = {}){
    commit('setProducts', [true])
    url = url||'/products'
    return axiosClient.get(url, {
        params: {
            search,
            per_page: perPage,
            sort_field,
            sort_direction
        }
    })
    .then((res)=>{
        commit('setProducts', [false, res.data])
    })
    .catch(()=>{
        commit('setProducts', [false])
    })

}

export function createProduct({commit}, product){
    if(product.images && product.images.length){
        const form = new FormData()
        form.append('title', product.title)
        //product.images = [...$event.target.files]
        product.images.forEach(im=>form.append('images[]', im))
        form.append('description', product.description || '')
        form.append('price', product.price)
        form.append('category_id', product.category_id)
        product = form
    }
    return axiosClient.post('/products', product)
}

export function getProduct({}, slug){
    return axiosClient.get(`/products/${slug}`)
}

export function updateProduct({}, product){
    console.log('from update product action', product)
    const slug = product.slug
    if(product.images && product.images.length){
        const form = new FormData();
        form.append('id', product.id)
        form.append('title', product.title)
        product.images.forEach(im=>form.append('images[]', im))
        if(product.deleted_images){
            product.deleted_images.forEach(id=>form.append('deleted_images[]', id))
        }
        form.append('description', product.description || '')
        form.append('price', product.price)
        form.append('category_id', product.category_id)
        form.append('length', product.length)
        form.append('width', product.width)
        form.append('depth', product.depth)
        form.append('sitting_height', product.sitting_height)
        form.append('hard_eyes', product.hard_eyes)
        form.append('main_material', product.main_material)
        form.append('inner_filling_material', product.inner_filling_material)
        form.append('_method', 'PUT')
        product = form
    }else{
        product._method = 'PUT'
    }
    return axiosClient.post(`/products/${slug}`, product)
}

export function deleteProduct({}, product){
    return axiosClient.delete(`/products/${product.id}`);
}


// categories
export function getCategories({commit}, {sort_field, sort_direction} = {}){
    commit('setCategories', [true])
    return axiosClient.get('/categories', {
        params: {
            sort_field,
            sort_direction
        }
    })
    .then((res)=>{
        commit('setCategories', [false, res.data])
    })
    .catch(()=>{
        commit('setCategories', [false])
    })
}

export function createCategory({}, category){
    return axiosClient.post('/categories', category);
}

export function updateCategory({}, category){
    return axiosClient.put(`/categories/${category.id}`, category);
}

export function deleteCategory({}, category){
    return axiosClient.delete(`/categories/${category.id}`);
}

export function getCategory({}, id){
    return axiosClient.get(`/categories/${id}`)
}
