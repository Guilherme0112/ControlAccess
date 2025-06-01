import { LoginRequest } from "resources/types/requests/LoginRequest";

export async function fazerLogin(loginRequest: LoginRequest) {
    try {

        const res = await fetch("/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(loginRequest )
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