export interface LoginPayload {
    email: string;
    password: string;
    role: "customer" | "admin";
}
