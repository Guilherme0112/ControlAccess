
export function formatDate(date: string){
    if (!date) return "";
    
    const dateObj = new Date(date);
    return dateObj.toLocaleString("pt-BR", {
        timeZone: "America/Sao_Paulo",
        day: "2-digit",
        month: "2-digit",
        year: "numeric"
    })
}