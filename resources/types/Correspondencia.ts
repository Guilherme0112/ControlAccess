interface Correspondencia{
    id: string,
    nome: string, 
    email_usuario: string,
    caixa_postal: string,
    unidade: string,
    status: string,
    remetente: string,
    data_recebimento: Date,
    correspondencia: File | null
}