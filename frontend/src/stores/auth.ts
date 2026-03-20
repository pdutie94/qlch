import { defineStore } from 'pinia'

const sessionKey = 'qlch:session'

export type UserRole = 'admin' | 'staff'

export interface AuthSession {
  name: string
  role: UserRole
  token: string
}

function readSession(): AuthSession | null {
  const raw = localStorage.getItem(sessionKey)
  if (!raw) {
    return null
  }

  try {
    return JSON.parse(raw) as AuthSession
  } catch {
    localStorage.removeItem(sessionKey)
    return null
  }
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    session: readSession() as AuthSession | null,
  }),
  getters: {
    isAuthenticated: (state) => state.session !== null,
  },
  actions: {
    signIn(name: string, role: UserRole) {
      this.session = {
        name: name.trim() || 'Store Staff',
        role,
        token: `demo-${Date.now()}`,
      }
      localStorage.setItem(sessionKey, JSON.stringify(this.session))
    },
    signOut() {
      this.session = null
      localStorage.removeItem(sessionKey)
    },
  },
})
