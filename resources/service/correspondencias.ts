
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

export async function buscarCorrespondenciasPorSessao() {
    try {
        const res = await fetch("/api/correspondencias/sessao", {
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

        const formData = new FormData();
        const data = new Date(correspondencia.data_recebimento);

        formData.append("nome", correspondencia.nome);
        formData.append("email_usuario", correspondencia.email_usuario);
        formData.append("caixa_postal", correspondencia.caixa_postal);
        formData.append("unidade", correspondencia.unidade);
        formData.append("remetente", correspondencia.remetente);
        formData.append("status", correspondencia.status);
        formData.append("data_recebimento", data.toISOString().split("T")[0]);

        if (correspondencia.correspondencia) {
            formData.append("correspondencia", correspondencia.correspondencia);
        }

        const res = await fetch("/api/correspondencias", {
            method: "POST",
            credentials: "include",
            body: formData
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

    const formData = new FormData();
    const data = new Date(correspondencia.data_recebimento);

    console.log(correspondencia);

    formData.append("_method", 'PUT');
    formData.append("nome", correspondencia.nome);
    formData.append("email_usuario", correspondencia.email_usuario);
    formData.append("caixa_postal", correspondencia.caixa_postal);
    formData.append("unidade", correspondencia.unidade);
    formData.append("remetente", correspondencia.remetente);
    formData.append("status", correspondencia.status);
    formData.append("data_recebimento", data.toISOString().split("T")[0]);

    if (correspondencia.correspondencia) formData.append("correspondencia", correspondencia.correspondencia);
    
    try {
        if (!correspondencia.id) throw new Error("Ocorreu algum erro. Tente novamente mais tarde");

        const res = await fetch(`/api/correspondencias/${correspondencia.id}`, {
            method: "POST",
            credentials: "include",
            body: formData
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

export async function aprovarAbertura(idCorrespondencia: string) {
    try {
        const res = await fetch(`/api/correspondencias/aprovar-abertura`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "include",
            body: JSON.stringify({
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