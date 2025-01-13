export class TokenService {
  private static tokenKey = 'authToken';

  static saveToken(token: string) {
    localStorage.setItem(this.tokenKey, token);
  }

  static getToken(): string | null {
    return localStorage.getItem(this.tokenKey);
  }

  static clearToken() {
    localStorage.removeItem(this.tokenKey);
  }
}
