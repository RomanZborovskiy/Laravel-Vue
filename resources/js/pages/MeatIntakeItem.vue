<template>
  <div class="container">
    <div class="item-form">
      <h2>Додати новий елемент</h2>
      
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <select 
            id="type_id" 
            v-model="formData.type_id"
            @change="loadPartsByType(formData.type_id)"
            required
            class="form-control"
          >
            <option disabled value="">-- Виберіть вид --</option>
            <option v-for="type in types" :key="type.id" :value="type.id">
              {{ type.name }}
            </option>
          </select>

          <label for="part_id">Частина:</label>
          <select 
            id="part_id" 
            v-model="formData.part_id"
            required
            class="form-control"
          >
            <option disabled value="">-- Виберіть частину --</option>
            <option v-for="part in parts" :key="part.id" :value="part.id">
              {{ part.name }}
            </option>
          </select>
          <label for="name">Кількість:</label>
          <input 
            type="text" 
            id="name" 
            v-model="formData.quantity" 
            required
            class="form-control"
            :class="{'is-invalid': errors.name}"
          >
          <div v-if="errors.name" class="invalid-feedback">
            {{ errors.name }}
          </div>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="loading">
          <span v-if="loading">Збереження...</span>
          <span v-else>Зберегти</span>
        </button>
      </form>

      <div v-if="successMessage" class="alert alert-success mt-3">
        {{ successMessage }}
      </div>

      <div v-if="errorMessage" class="alert alert-danger mt-3">
        {{ errorMessage }}
      </div>
    </div>

    <div class="mt-5">
      <h3>Список елементів</h3>
      <div class="table-responsive">
        <table class="table table-striped mt-4">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Назва робочої зміни</th>
              <th>Вид м'яса</th>
              <th>Частина м'яса</th>
              <th>Кількість</th>
              <th>Кнопка</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="meat in meats" :key="meat.id">
              <td>{{ meat.id }}</td>
              <td>{{ meat.intake_name }}</td>
              <td>{{ meat.type_name }}</td>
              <td>{{ meat.part_of_meat}}</td>
              <td>{{ meat.quantity}}</td>
              <th>
                  <button @click="goTo(meat.id)">
                    {{ meat.status ? 'Редагувати' : 'Створити' }}
                  </button>
              </th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { selectDark } from 'naive-ui';
import api from '../api/api';

export default {
  data() {
    return {
      meats:[],
      types: [],       
      parts: [],
      idForIntake: this.$route.params.id,
      formData: {
        intake_id: '',
        type_id: '',
        part_id: '',
        quantity: '',
      },
      errors: {},
      successMessage: '',
      errorMessage: '',
      loading: false
    };
  },
  async created() {
    await this.loadItems();
    await this.loadTypes();
  },
  methods: {
      async loadTypes() {
      try {
        const response = await api.get('/meat_types'); 
        this.types = response.data.data;
      } catch (error) {
        console.error('Не вдалося завантажити типи:', error);
      }
    },

    async loadPartsByType(typeId) {
      try {
        const response = await api.get(`meat_part/${typeId}/part`); 
        this.parts = response.data.data;
      } catch (error) {
        console.error('Не вдалося завантажити частини:', error);
      }
    },
    async loadItems() {
      try {
        const response = await api.get(`meat_intake_item/${this.idForIntake}/intake`);
        this.meats = response.data.data || response.data; 
        //console.log(response);
      } catch (error) {
        console.error('Помилка завантаження:', error);
        this.errorMessage = 'Не вдалося завантажити дані';
      }
    },
    
    validateForm() {
      this.errors = {};
      let isValid = true;

      if (!this.formData.quantity.trim()) {
        this.errors.name = 'Будь ласка, введіть назву';
        isValid = false;
      }


      return isValid;
    },
    
    async submitForm() {
      if (!this.validateForm()) return;

      this.loading = true;
      this.successMessage = '';
      this.errorMessage = '';
      this.formData.intake_id = this.idForIntake;

      try {
        const response = await api.post('meat_intake_item', this.formData);       
        this.successMessage = 'Дані успішно збережено!';
        this.resetForm();
        await this.loadItems(); 
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors || {};
          this.errorMessage = 'Будь ласка, виправте помилки у формі';
        } else {
          this.errorMessage = 'Помилка при збереженні: ' + 
            (error.response?.data?.message || error.message);
        }
      } finally {
        this.loading = false;
      }
    },
    
    resetForm() {
      this.formData = {
        name: '',
        user_id: '',
      };
      this.errors = {};
    },
    
    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleString();
    },

    goTo(id) {
      const selectedMeat = this.meats.find(m => m.id === id);
      if (!selectedMeat) return;

      const partId = selectedMeat.part_id;
      const status = selectedMeat.status;

      const path = status
        ? `/meat_cut_output/${id}/edit`
        : `/meat_cut_output/${id}/store`;
      this.$router.push({
        path,
        query: { part_id: partId }
      });
    },
  }
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.item-form {
  background: #f8f9fa;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #495057;
}

.form-control {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 16px;
  transition: border-color 0.15s;
}

.form-control:focus {
  border-color: #80bdff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.is-invalid {
  border-color: #dc3545;
}

.invalid-feedback {
  color: #dc3545;
  font-size: 14px;
  margin-top: 5px;
}

.btn {
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 4px;
  transition: all 0.3s;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0069d9;
  border-color: #0062cc;
}

.btn-primary:disabled {
  background-color: #6c757d;
  border-color: #6c757d;
  cursor: not-allowed;
}

.alert {
  padding: 15px;
  border-radius: 4px;
  margin-top: 20px;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.table {
  margin-top: 30px;
  width: 100%;
}

.thead-dark {
  background-color: #343a40;
  color: white;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}

.table-responsive {
  overflow-x: auto;
}
</style>