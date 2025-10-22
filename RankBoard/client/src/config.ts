// API Configuration
// Update this file to point to your Laravel backend

export const config = {
  apiBaseUrl: "http://localhost:8000", // Your Laravel backend URL

  // API endpoints
  endpoints: {
    leaderboard: "/api/leaderboard",
    authCheck: "/api/auth/check",
  },

  // Laravel page URLs
  pages: {
    login: "/login",
    register: "/register",
  },
} as const;

// Helper to build full API URLs
export function getApiUrl(endpoint: string): string {
  if (!config.apiBaseUrl) {
    // If no base URL is set, use relative URLs (same domain)
    return endpoint;
  }
  return `${config.apiBaseUrl}${endpoint}`;
}

// Helper to build full Laravel page URLs
export function getPageUrl(page: string): string {
  if (!config.apiBaseUrl) {
    return page;
  }
  return `${config.apiBaseUrl}${page}`;
}
