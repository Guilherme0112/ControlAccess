import { LoginRequest } from "resources/types/requests/LoginRequest";

export async function fazerLogin(loginRequest: LoginRequest) {
    try {

        const res = await fetch("/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "include",
            body: JSON.stringify(loginRequest)
        });

        if (!res.ok) {
            const errorData = await res.json();
            throw errorData;
        }

        return await res.json();
    } catch (error) {
        throw error;
    }
}
export async function fazerLogout() {
    try {

        const res = await fetch("/api/logout", {
            method: "POST",
            credentials: "include",
        });

        if (!res.ok) {
            const errorData = await res.json();
            throw errorData;
        }

        return await res.json();
    } catch (error) {
        throw error;
    }
}