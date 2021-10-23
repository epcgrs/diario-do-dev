/*
 * VueX - State Management
 */

import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import auth from './modules/auth'
import contents from './modules/content'

const themeActiveLocal = localStorage.getItem('theme')
let themeState = themeActiveLocal ?
    { colorTheme: themeActiveLocal } : { colorTheme: 'light' };

const helpers = {
    getWindowWidth () {
        return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
    },
    getCurrentYear () {
        return new Date().getFullYear()
    }
}

export default new Vuex.Store({
    state: {
        // App vital details
        app: {
            name: 'DiarioDoDev',
            version: '0.0.1',
            copyright: helpers.getCurrentYear()
        },
        settings: themeState,
    },
    getters: {
        // Get App name
        appName: (state) => {
            return state.app.name
        },
        // Get App version
        appVersion: (state) => {
            return state.app.version
        },
        // Get App copyright year
        appCopyright: (state) => {
            return state.app.copyright
        },
        // Get app color theme
        appColorTheme: (state) => {
            return state.settings.colorTheme
        }
    },
    mutations: {
        pageLoader (state, payload) {
            if (payload.mode === 'on') {
                state.settings.pageLoader = true
            } else if (payload.mode === 'off') {
                state.settings.pageLoader = false
            } else if (payload.mode === 'toggle') {
                state.settings.pageLoader = !state.settings.pageLoader
            }
        },
        // Sets active color theme
        setColorTheme (state, payload) {
            // Matches all classes which start with "theme-"
            let regx = new RegExp('\\btheme-[^ ]*[ ]?\\b', 'g')

            // Set new theme
            state.settings.colorTheme = payload.theme || ''

            // Remove all classes which start with "theme-" from body element
            document.body.className = document.body.className.replace(regx, '')

            // If theme is set, add the theme class to body element
            if (payload.theme) {
                document.body.classList.add('theme-' + payload.theme)
                localStorage.setItem('theme', payload.theme)
            }
        }
    },
    modules: {
        auth: auth,
        contents: contents
    }
})

