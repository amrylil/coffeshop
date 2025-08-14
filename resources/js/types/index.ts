export interface User {
    email: string;
    name: string;
    password: string;
    gender: string;
    role: string;
    address: string;
    phone: string;
    birth_date: string;
    profile_photo: string | null;
}

export interface PageProps {
    [key: string]: unknown;
    auth: {
        user: User | null;
    };
    errors?: Record<string, string>;
}
