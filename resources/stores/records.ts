import { defineStore } from 'pinia';
import { ref } from 'vue';

interface Record {
  id: string;
  name: string;
  email: string;
  postalBox: string;
  attachment: string;
  unit: string;
  receivedDate: string;
  status: 'pendente' | 'recebido' | 'enviado';
}

export const useRecordsStore = defineStore('records', () => {
  const records = ref<Record[]>([]);

  const addRecord = (record: Omit<Record, 'id'>) => {
    records.value.push({
      ...record,
      id: Math.random().toString(36).substr(2, 9)
    });
  };

  const updateStatus = (id: string, status: Record['status']) => {
    const record = records.value.find(r => r.id === id);
    if (record) {
      record.status = status;
    }
  };

  const getRecordsByEmail = (email: string) => {
    return records.value.filter(record => record.email === email);
  };

  return { records, addRecord, updateStatus, getRecordsByEmail };
});