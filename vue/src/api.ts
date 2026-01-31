import router from './router'

export interface Api {
    readonly baseUrl: string
    index<T = unknown>(path: string, query?: string): Promise<T>
    view<T = unknown>(path: string, query?: string): Promise<T>
    update<T = unknown>(path: string, query?: string): Promise<T>
    delete<T = unknown>(path: string, query?: string): Promise<T>
    translatorAvailabilityList<T = unknown>(): Promise<T> // list of translator availability options
    request<T = unknown>(method: string, path: string, data = ''): Promise<T>
}

const baseUrl = import.meta.env.VUE_APP_API_URL

export const api: Api = {
    baseUrl,
    async index<T>(path: string, query = ''): Promise<T>{
        return api.request('GET', path+'/index'+query)
    },
    async view<T>(path: string, query = ''): Promise<T>{
        const id = router.currentRoute.value.params.id
        return api.request('GET', path+'/view?id='+id+query)
    },
    async update<T>(path: string, query = '', data): Promise<T>{
        const id = router.currentRoute.value.params.id
        return api.request('PUT', path+'/update'+(query ? query : "?id="+id), data)
    },
    async delete<T>(path: string, query = ''): Promise<T>{
        const id = router.currentRoute.value.params.id
        return api.request('DELETE', path+'/update'+(query ? query : "?id="+id))
    },
    async translatorAvailabilityList() {
        return api.request('GET', '/project/translator/availability-list')
    },
    async request(method, path, data = '') {
        const settings = {
            method: method,
            headers: {'Content-Type': 'application/json'},
        }
        if (data) {
            settings.body = JSON.stringify(data.value)
        }
        const response = await fetch(baseUrl+path, settings)
        if (!response.ok) {
            throw new Error(`API error: ${response.status}`)
        }
        return response.json() as Promise<T>
    }
}
