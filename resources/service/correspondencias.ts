
export async function buscarCorrespondencias() {
    try {
        const res = await fetch("/api/correspondencias", {
            method: "GET",
            credentials: "include"
        });

        return await res.json();
    } catch (error) {
        throw error;
    }
}

export async function salvarCorrespondencia(correspondencia: Correspondencia) {
    try {

        const res = await fetch("/api/correspondencias", {
            method: "POST",
            credentials: "include",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(correspondencia)
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

export async function editarCorrespondencia(correspondencia: Correspondencia) {
    try {
        const res = await fetch("/api/correspondencias", {
            method: "POST",
            credentials: "include",
            body: JSON.stringify(correspondencia)
        });

        return await res.json();
    } catch (error) {
        throw error;
    }
}


export async function notificacaoChegada(email: string, idCorrespondencia: string) {
    try {
        const res = await fetch("/api/correspondencias/notificar-chegada", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "include",
            body: JSON.stringify({ 
                "email": email,
                "idCorrespondencia": idCorrespondencia
            })
        });

        return await res.json();
    } catch (error) {
        throw error;
    }
}
export async function apagarCorrespondencia(correspondencia: Correspondencia) {
    console.log(correspondencia)
}